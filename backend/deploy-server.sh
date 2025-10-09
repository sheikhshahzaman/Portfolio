#!/bin/bash

# Server Deployment Script
# Run this script on your Hostinger server after uploading files

set -e

echo "🚀 Setting up application on server..."

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${BLUE}Creating .env file...${NC}"
    if [ -f .env.production ]; then
        cp .env.production .env
        echo -e "${GREEN}✓ .env created from .env.production${NC}"
        echo -e "${RED}! Please edit .env and configure your database and other settings${NC}"
    else
        echo -e "${RED}✗ .env.production not found. Please create .env manually${NC}"
        exit 1
    fi
fi

# Generate application key
echo -e "${BLUE}Generating application key...${NC}"
php artisan key:generate --force
echo -e "${GREEN}✓ Application key generated${NC}"

# Install dependencies (if composer available)
if command -v composer &> /dev/null; then
    echo -e "${BLUE}Installing dependencies...${NC}"
    composer install --optimize-autoloader --no-dev
    echo -e "${GREEN}✓ Dependencies installed${NC}"
fi

# Set permissions
echo -e "${BLUE}Setting permissions...${NC}"
chmod -R 755 storage bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"

# Create storage link
echo -e "${BLUE}Creating storage link...${NC}"
php artisan storage:link
echo -e "${GREEN}✓ Storage link created${NC}"

# Run migrations
echo -e "${BLUE}Running migrations...${NC}"
read -p "Do you want to run migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo -e "${GREEN}✓ Migrations completed${NC}"
fi

# Sync translations
echo -e "${BLUE}Syncing translations...${NC}"
read -p "Do you want to sync translation keys? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan translations:sync
    echo -e "${GREEN}✓ Translations synced${NC}"
fi

# Clear and cache
echo -e "${BLUE}Clearing caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo -e "${BLUE}Caching for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo -e "${GREEN}✓ Caches optimized${NC}"

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ Server deployment complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Important reminders:"
echo "1. Make sure document root points to 'public' folder"
echo "2. Verify .env has correct database credentials"
echo "3. Ensure SSL certificate is installed"
echo "4. Test your application thoroughly"
echo ""
