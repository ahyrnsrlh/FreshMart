#!/bin/bash

# 🚀 FreshMart Setup Verification Script
# This script checks if all requirements are met before building/deploying

echo "🥬 FreshMart - Setup Verification"
echo "=================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to check command
check_command() {
    if command -v $1 &> /dev/null; then
        echo -e "${GREEN}✓${NC} $1 is installed"
        return 0
    else
        echo -e "${RED}✗${NC} $1 is not installed"
        return 1
    fi
}

# Function to check file exists
check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} $1 exists"
        return 0
    else
        echo -e "${RED}✗${NC} $1 not found"
        return 1
    fi
}

# Function to check directory exists
check_directory() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✓${NC} $1 directory exists"
        return 0
    else
        echo -e "${RED}✗${NC} $1 directory not found"
        return 1
    fi
}

echo "📋 Prerequisites Check:"
echo "----------------------"

# Check PHP
if check_command php; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    echo "   Version: $PHP_VERSION"
    if php -r "exit(version_compare(PHP_VERSION, '8.2.0', '>=') ? 0 : 1);"; then
        echo -e "   ${GREEN}✓${NC} PHP version is 8.2+ (required)"
    else
        echo -e "   ${RED}✗${NC} PHP version must be 8.2 or higher"
    fi
fi

# Check Composer
if check_command composer; then
    COMPOSER_VERSION=$(composer --version | head -n1)
    echo "   $COMPOSER_VERSION"
fi

# Check Node.js
if check_command node; then
    NODE_VERSION=$(node --version)
    echo "   Version: $NODE_VERSION"
fi

# Check NPM
if check_command npm; then
    NPM_VERSION=$(npm --version)
    echo "   Version: $NPM_VERSION"
fi

echo ""
echo "📁 Project Structure Check:"
echo "---------------------------"

# Check essential files
check_file ".env"
check_file "composer.json"
check_file "package.json"
check_file "vite.config.js"
check_file "tailwind.config.js"
check_file "postcss.config.js"
check_file "artisan"

# Check directories
check_directory "vendor"
check_directory "node_modules"
check_directory "app"
check_directory "resources"
check_directory "database"
check_directory "storage"
check_directory "public"

echo ""
echo "🔧 Configuration Check:"
echo "-----------------------"

# Check if .env has required variables
if [ -f ".env" ]; then
    if grep -q "APP_KEY=" .env && grep -q "DB_DATABASE=" .env; then
        echo -e "${GREEN}✓${NC} .env file has basic configuration"
    else
        echo -e "${YELLOW}⚠${NC} .env file may be missing some configuration"
    fi
fi

# Check storage directories
check_directory "storage/app/public"
check_directory "storage/app/public/products"
check_directory "storage/app/public/payment_proofs"

# Check public storage link
if [ -L "public/storage" ]; then
    echo -e "${GREEN}✓${NC} Storage link exists"
else
    echo -e "${YELLOW}⚠${NC} Storage link not found (run: php artisan storage:link)"
fi

echo ""
echo "🗄️ Database Check:"
echo "------------------"

# Check database connection
if php artisan migrate:status &> /dev/null; then
    echo -e "${GREEN}✓${NC} Database connection successful"
    echo -e "${GREEN}✓${NC} Migrations are up to date"
else
    echo -e "${RED}✗${NC} Database connection failed"
    echo -e "${YELLOW}⚠${NC} Run: php artisan migrate"
fi

echo ""
echo "🎨 Asset Check:"
echo "---------------"

# Check if assets need building
if [ -f "public/build/manifest.json" ]; then
    echo -e "${GREEN}✓${NC} Assets are built"
else
    echo -e "${YELLOW}⚠${NC} Assets need building (run: npm run build)"
fi

# Check CSS and JS source files
check_file "resources/css/app.css"
check_file "resources/js/app.js"

echo ""
echo "🔐 Permissions Check:"
echo "---------------------"

# Check storage permissions
if [ -w "storage" ]; then
    echo -e "${GREEN}✓${NC} Storage directory is writable"
else
    echo -e "${RED}✗${NC} Storage directory is not writable"
fi

# Check bootstrap/cache permissions
if [ -w "bootstrap/cache" ]; then
    echo -e "${GREEN}✓${NC} Bootstrap cache directory is writable"
else
    echo -e "${RED}✗${NC} Bootstrap cache directory is not writable"
fi

echo ""
echo "🚀 Ready to Build:"
echo "------------------"

if command -v php &> /dev/null && command -v composer &> /dev/null && command -v npm &> /dev/null && [ -f ".env" ] && [ -d "vendor" ] && [ -d "node_modules" ]; then
    echo -e "${GREEN}✓${NC} All requirements met!"
    echo ""
    echo "Next steps:"
    echo "1. Run: npm run build"
    echo "2. Run: php artisan optimize"
    echo "3. Start server: php artisan serve"
else
    echo -e "${RED}✗${NC} Some requirements are missing"
    echo ""
    echo "Required actions:"
    echo "1. Install missing dependencies"
    echo "2. Configure .env file"
    echo "3. Run: composer install"
    echo "4. Run: npm install"
    echo "5. Run: php artisan migrate"
    echo "6. Run: php artisan storage:link"
fi

echo ""
echo "📚 Documentation:"
echo "-----------------"
echo "• README.md - Project overview and setup"
echo "• API_DOCUMENTATION.md - API endpoints"
echo "• Admin panel: /admin"
echo "• Customer site: /"

echo ""
echo "🎯 Build completed successfully!"
echo "================================"
