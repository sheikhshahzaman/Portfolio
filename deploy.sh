#!/bin/bash

# ============================================================
# Portfolio — LOCAL build & package script
# Run this on your machine. It builds the public site + the
# admin panel, bundles everything into backend/, and zips a
# ready-to-upload archive (portfolio-production.zip).
# Then upload + extract on the server and run deploy-server.sh.
# ============================================================

set -e  # exit on error

GREEN='\033[0;32m'; BLUE='\033[0;34m'; RED='\033[0;31m'; YELLOW='\033[1;33m'; NC='\033[0m'
ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT"

echo -e "${BLUE}🚀 Building portfolio for production...${NC}"

# ----- Step 1: Build the public site (Vue + Vite) -----
echo -e "${BLUE}Step 1/6: Building public site (frontend)...${NC}"
cd "$ROOT/frontend"
npm install                 # installs lenis + other deps
npm run build               # -> frontend/dist
echo -e "${GREEN}✓ Public site built${NC}"

# ----- Step 2: Build the admin panel (Inertia + Vite) -----
echo -e "${BLUE}Step 2/6: Building admin panel (backend assets)...${NC}"
cd "$ROOT/backend"
npm install
npm run build               # -> backend/public/build  (gitignored, so build it here)
echo -e "${GREEN}✓ Admin panel built${NC}"

# ----- Step 3: Copy public-site build into backend/public -----
echo -e "${BLUE}Step 3/6: Copying public site into backend/public...${NC}"
cd "$ROOT"
rm -rf backend/public/assets
rm -f  backend/public/index.html
cp -r frontend/dist/* backend/public/     # index.html, assets/, favicons, resume.pdf, manifest
echo -e "${GREEN}✓ Public site copied (admin assets in public/build are untouched)${NC}"

# ----- Step 4: Install PHP dependencies (production) -----
echo -e "${BLUE}Step 4/6: Installing PHP dependencies...${NC}"
cd "$ROOT/backend"
composer install --optimize-autoloader --no-dev
echo -e "${GREEN}✓ Composer dependencies installed${NC}"

# ----- Step 5: Refresh + cache config (also silences the PHP 8.5 PDO
#               deprecation that can corrupt API JSON) -----
echo -e "${BLUE}Step 5/6: Caching config/routes/views...${NC}"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Caches built${NC}"

# ----- Step 6: Create the upload archive -----
echo -e "${BLUE}Step 6/6: Creating deployment archive...${NC}"
cd "$ROOT"
rm -f portfolio-production.zip
zip -r portfolio-production.zip backend \
    -x "backend/node_modules/*" \
    -x "backend/.git/*" \
    -x "backend/storage/logs/*" \
    -x "backend/database/database.sqlite" \
    -x "backend/.env"
echo -e "${GREEN}✓ Archive created: portfolio-production.zip${NC}"

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ Build complete${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Next steps on the server:"
echo "  1. Upload & extract portfolio-production.zip"
echo "  2. cp .env.production .env   (first deploy only) and configure it"
echo "  3. Run: bash deploy-server.sh"
echo "  4. Point the web server document root at backend/public"
echo ""
echo -e "${YELLOW}NOTE: never run 'php artisan db:seed' on production — the"
echo -e "PortfolioSeeder creates demo rows and would duplicate your content.${NC}"
