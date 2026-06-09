#!/bin/bash

# ============================================================
# Portfolio — SERVER setup script
# Run this on the server (inside the backend/ folder) after
# uploading & extracting portfolio-production.zip.
# Safe to re-run for subsequent deploys.
# ============================================================

set -e

GREEN='\033[0;32m'; BLUE='\033[0;34m'; RED='\033[0;31m'; YELLOW='\033[1;33m'; NC='\033[0m'

# ----- .env -----
if [ ! -f .env ]; then
    if [ -f .env.production ]; then
        cp .env.production .env
        echo -e "${GREEN}✓ .env created from .env.production${NC}"
        echo -e "${RED}! Edit .env and set your DB credentials, APP_URL, etc.${NC}"
    else
        echo -e "${RED}✗ No .env or .env.production found. Create .env manually.${NC}"
        exit 1
    fi
fi

# ----- App key (only generates if missing) -----
if ! grep -q "^APP_KEY=base64" .env 2>/dev/null; then
    php artisan key:generate --force
    echo -e "${GREEN}✓ Application key generated${NC}"
fi

# ----- PHP dependencies (if composer is on the server) -----
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev
    echo -e "${GREEN}✓ Composer dependencies installed${NC}"
fi

# ----- Permissions -----
chmod -R 775 storage bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"

# ----- Storage symlink (for uploaded media: project covers, avatars) -----
php artisan storage:link || true
echo -e "${GREEN}✓ Storage link ensured${NC}"

# ----- Migrations (no new schema in this release, but safe/standard) -----
php artisan migrate --force
echo -e "${GREEN}✓ Migrations up to date${NC}"

# ----- Translation keys: adds any NEW section-copy keys so they are
#       editable in admin -> Translation Keys. Idempotent (updateOrCreate).
#       This does NOT touch your content rows. -----
php artisan db:seed --class=TranslationKeySeeder --force
echo -e "${GREEN}✓ Translation keys synced${NC}"

# ----- Refresh + cache (config:cache also silences the PHP 8.5 PDO
#       deprecation that can otherwise corrupt API JSON) -----
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Caches optimized${NC}"

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ Server deployment complete${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Reminders:"
echo "  • Web server document root must point to: backend/public"
echo "  • Theme palette / logo + About principles are set in admin → Settings"
echo "  • Resume: bundled at /resume.pdf, or set 'Resume URL' in admin Settings"
echo ""
echo -e "${YELLOW}DO NOT run 'php artisan db:seed' or '--class=PortfolioSeeder'${NC}"
echo -e "${YELLOW}— those create demo rows and would duplicate your real content.${NC}"
