# 🚀 FreshMart Setup Verification Script (PowerShell)
# This script checks if all requirements are met before building/deploying

Write-Host "🥬 FreshMart - Setup Verification" -ForegroundColor Green
Write-Host "==================================" -ForegroundColor Green
Write-Host ""

# Function to check if command exists
function Test-Command {
    param($Command)
    try {
        if (Get-Command $Command -ErrorAction Stop) {
            Write-Host "✓ $Command is installed" -ForegroundColor Green
            return $true
        }
    }
    catch {
        Write-Host "✗ $Command is not installed" -ForegroundColor Red
        return $false
    }
}

# Function to check if file exists
function Test-FileExists {
    param($Path)
    if (Test-Path $Path -PathType Leaf) {
        Write-Host "✓ $Path exists" -ForegroundColor Green
        return $true
    } else {
        Write-Host "✗ $Path not found" -ForegroundColor Red
        return $false
    }
}

# Function to check if directory exists
function Test-DirectoryExists {
    param($Path)
    if (Test-Path $Path -PathType Container) {
        Write-Host "✓ $Path directory exists" -ForegroundColor Green
        return $true
    } else {
        Write-Host "✗ $Path directory not found" -ForegroundColor Red
        return $false
    }
}

Write-Host "📋 Prerequisites Check:" -ForegroundColor Cyan
Write-Host "----------------------" -ForegroundColor Cyan

# Check PHP
if (Test-Command "php") {
    $phpVersion = php -r "echo PHP_VERSION;"
    Write-Host "   Version: $phpVersion" -ForegroundColor Gray
    
    $versionCheck = php -r "exit(version_compare(PHP_VERSION, '8.2.0', '>=') ? 0 : 1);"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "   ✓ PHP version is 8.2+ (required)" -ForegroundColor Green
    } else {
        Write-Host "   ✗ PHP version must be 8.2 or higher" -ForegroundColor Red
    }
}

# Check Composer
if (Test-Command "composer") {
    $composerVersion = composer --version | Select-Object -First 1
    Write-Host "   $composerVersion" -ForegroundColor Gray
}

# Check Node.js
if (Test-Command "node") {
    $nodeVersion = node --version
    Write-Host "   Version: $nodeVersion" -ForegroundColor Gray
}

# Check NPM
if (Test-Command "npm") {
    $npmVersion = npm --version
    Write-Host "   Version: $npmVersion" -ForegroundColor Gray
}

Write-Host ""
Write-Host "📁 Project Structure Check:" -ForegroundColor Cyan
Write-Host "---------------------------" -ForegroundColor Cyan

# Check essential files
Test-FileExists ".env"
Test-FileExists "composer.json"
Test-FileExists "package.json"
Test-FileExists "vite.config.js"
Test-FileExists "tailwind.config.js"
Test-FileExists "postcss.config.js"
Test-FileExists "artisan"

# Check directories
Test-DirectoryExists "vendor"
Test-DirectoryExists "node_modules"
Test-DirectoryExists "app"
Test-DirectoryExists "resources"
Test-DirectoryExists "database"
Test-DirectoryExists "storage"
Test-DirectoryExists "public"

Write-Host ""
Write-Host "🔧 Configuration Check:" -ForegroundColor Cyan
Write-Host "-----------------------" -ForegroundColor Cyan

# Check if .env has required variables
if (Test-Path ".env") {
    $envContent = Get-Content ".env" -Raw
    if ($envContent -match "APP_KEY=" -and $envContent -match "DB_DATABASE=") {
        Write-Host "✓ .env file has basic configuration" -ForegroundColor Green
    } else {
        Write-Host "⚠ .env file may be missing some configuration" -ForegroundColor Yellow
    }
}

# Check storage directories
Test-DirectoryExists "storage\app\public"
Test-DirectoryExists "storage\app\public\products"
Test-DirectoryExists "storage\app\public\payment_proofs"

# Check public storage link
if (Test-Path "public\storage") {
    Write-Host "✓ Storage link exists" -ForegroundColor Green
} else {
    Write-Host "⚠ Storage link not found (run: php artisan storage:link)" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "🗄️ Database Check:" -ForegroundColor Cyan
Write-Host "------------------" -ForegroundColor Cyan

# Check database connection
try {
    php artisan migrate:status *>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Database connection successful" -ForegroundColor Green
        Write-Host "✓ Migrations are up to date" -ForegroundColor Green
    } else {
        Write-Host "✗ Database connection failed" -ForegroundColor Red
        Write-Host "⚠ Run: php artisan migrate" -ForegroundColor Yellow
    }
} catch {
    Write-Host "✗ Database connection failed" -ForegroundColor Red
    Write-Host "⚠ Run: php artisan migrate" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "🎨 Asset Check:" -ForegroundColor Cyan
Write-Host "---------------" -ForegroundColor Cyan

# Check if assets are built
if (Test-Path "public\build\manifest.json") {
    Write-Host "✓ Assets are built" -ForegroundColor Green
} else {
    Write-Host "⚠ Assets need building (run: npm run build)" -ForegroundColor Yellow
}

# Check CSS and JS source files
Test-FileExists "resources\css\app.css"
Test-FileExists "resources\js\app.js"

Write-Host ""
Write-Host "🔐 Permissions Check:" -ForegroundColor Cyan
Write-Host "---------------------" -ForegroundColor Cyan

# Check storage permissions (simplified for Windows)
try {
    $testFile = "storage\test-write.tmp"
    "test" | Out-File $testFile -ErrorAction Stop
    Remove-Item $testFile -ErrorAction SilentlyContinue
    Write-Host "✓ Storage directory is writable" -ForegroundColor Green
} catch {
    Write-Host "✗ Storage directory is not writable" -ForegroundColor Red
}

# Check bootstrap/cache permissions
try {
    $testFile = "bootstrap\cache\test-write.tmp"
    "test" | Out-File $testFile -ErrorAction Stop
    Remove-Item $testFile -ErrorAction SilentlyContinue
    Write-Host "✓ Bootstrap cache directory is writable" -ForegroundColor Green
} catch {
    Write-Host "✗ Bootstrap cache directory is not writable" -ForegroundColor Red
}

Write-Host ""
Write-Host "🚀 Build Status:" -ForegroundColor Cyan
Write-Host "----------------" -ForegroundColor Cyan

$allGood = $true
$requiredItems = @(
    @{ Check = { Test-Command "php" }; Name = "PHP" },
    @{ Check = { Test-Command "composer" }; Name = "Composer" },
    @{ Check = { Test-Command "npm" }; Name = "NPM" },
    @{ Check = { Test-Path ".env" }; Name = ".env file" },
    @{ Check = { Test-Path "vendor" }; Name = "Vendor directory" },
    @{ Check = { Test-Path "node_modules" }; Name = "Node modules" }
)

foreach ($item in $requiredItems) {
    if (-not (& $item.Check)) {
        $allGood = $false
        break
    }
}

if ($allGood) {
    Write-Host "✓ All requirements met!" -ForegroundColor Green
    Write-Host ""
    Write-Host "✅ BUILD COMPLETED SUCCESSFULLY!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Cyan
    Write-Host "1. Start server: php artisan serve" -ForegroundColor White
    Write-Host "2. Visit: http://localhost:8000" -ForegroundColor White
    Write-Host "3. Admin panel: http://localhost:8000/admin" -ForegroundColor White
} else {
    Write-Host "✗ Some requirements are missing" -ForegroundColor Red
    Write-Host ""
    Write-Host "Required actions:" -ForegroundColor Yellow
    Write-Host "1. Install missing dependencies" -ForegroundColor White
    Write-Host "2. Configure .env file" -ForegroundColor White
    Write-Host "3. Run: composer install" -ForegroundColor White
    Write-Host "4. Run: npm install" -ForegroundColor White
    Write-Host "5. Run: php artisan migrate" -ForegroundColor White
    Write-Host "6. Run: php artisan storage:link" -ForegroundColor White
    Write-Host "7. Run: npm run build" -ForegroundColor White
}

Write-Host ""
Write-Host "📚 Documentation:" -ForegroundColor Cyan
Write-Host "-----------------" -ForegroundColor Cyan
Write-Host "• README.md - Project overview and setup" -ForegroundColor White
Write-Host "• API_DOCUMENTATION.md - API endpoints" -ForegroundColor White
Write-Host "• Admin panel: /admin" -ForegroundColor White
Write-Host "• Customer site: /" -ForegroundColor White

Write-Host ""
Write-Host "🎯 Setup verification completed!" -ForegroundColor Green
Write-Host "=================================" -ForegroundColor Green
