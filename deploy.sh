#!/bin/bash

# Portfolio Deployment Script
# This script prepares your application for production deployment

set -e  # Exit on error

echo "🚀 Starting deployment preparation..."

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Step 1: Build Frontend
echo -e "${BLUE}Step 1: Building frontend...${NC}"
cd frontend
npm install
npm run build

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Frontend built successfully${NC}"
else
    echo -e "${RED}✗ Frontend build failed${NC}"
    exit 1
fi

# Step 2: Copy frontend build to backend public
echo -e "${BLUE}Step 2: Copying frontend to backend...${NC}"
cd ..
rm -rf backend/public/assets
rm -f backend/public/index.html
cp -r frontend/dist/* backend/public/

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Frontend copied to backend/public${NC}"
else
    echo -e "${RED}✗ Failed to copy frontend${NC}"
    exit 1
fi

# Step 3: Install production dependencies
echo -e "${BLUE}Step 3: Installing production dependencies...${NC}"
cd backend
composer install --optimize-autoloader --no-dev

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Dependencies installed${NC}"
else
    echo -e "${RED}✗ Failed to install dependencies${NC}"
    exit 1
fi

# Step 4: Clear caches
echo -e "${BLUE}Step 4: Clearing caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo -e "${GREEN}✓ Caches cleared${NC}"

# Step 5: Optimize for production
echo -e "${BLUE}Step 5: Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo -e "${GREEN}✓ Application optimized${NC}"

# Step 6: Create deployment archive
echo -e "${BLUE}Step 6: Creating deployment archive...${NC}"
cd ..
zip -r portfolio-production.zip backend \
    -x "backend/node_modules/*" \
    -x "backend/.git/*" \
    -x "backend/storage/logs/*" \
    -x "backend/database/database.sqlite" \
    -x "backend/.env"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Deployment archive created: portfolio-production.zip${NC}"
else
    echo -e "${RED}✗ Failed to create archive${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ Deployment preparation complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Next steps:"
echo "1. Upload 'portfolio-production.zip' to your Hostinger hosting"
echo "2. Extract the archive"
echo "3. Copy .env.production to .env and configure it"
echo "4. Run: php artisan key:generate"
echo "5. Run: php artisan migrate --force"
echo "6. Run: php artisan storage:link"
echo "7. Set document root to 'public' folder"
echo ""
echo "For detailed instructions, see DEPLOYMENT_GUIDE.md"
