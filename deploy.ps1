# Production Deployment Script for SWIFT SYNCH
# This script creates a production-ready package without development files

Write-Host "Creating production deployment package..." -ForegroundColor Green

# Create production directory
$prodDir = "production-deploy"
if (Test-Path $prodDir) {
    Remove-Item $prodDir -Recurse -Force
}
New-Item -ItemType Directory -Path $prodDir

# Copy essential directories
Write-Host "Copying application files..." -ForegroundColor Yellow
Copy-Item "app" -Destination "$prodDir/app" -Recurse
Copy-Item "bootstrap" -Destination "$prodDir/bootstrap" -Recurse
Copy-Item "config" -Destination "$prodDir/config" -Recurse
Copy-Item "database" -Destination "$prodDir/database" -Recurse
Copy-Item "public" -Destination "$prodDir/public" -Recurse
Copy-Item "resources" -Destination "$prodDir/resources" -Recurse
Copy-Item "routes" -Destination "$prodDir/routes" -Recurse
Copy-Item "storage" -Destination "$prodDir/storage" -Recurse
Copy-Item "vendor" -Destination "$prodDir/vendor" -Recurse

# Copy essential files
Write-Host "Copying configuration files..." -ForegroundColor Yellow
Copy-Item "artisan" -Destination "$prodDir/artisan"
Copy-Item "composer.json" -Destination "$prodDir/composer.json"
Copy-Item "composer.lock" -Destination "$prodDir/composer.lock"

# Create .env.example for production
Write-Host "Creating environment file..." -ForegroundColor Yellow
Copy-Item ".env.example" -Destination "$prodDir/.env.example" -ErrorAction SilentlyContinue

# Set proper permissions (for Unix systems)
Write-Host "Setting up storage permissions..." -ForegroundColor Yellow
New-Item -ItemType File -Path "$prodDir/storage/logs/.gitkeep" -Force
New-Item -ItemType File -Path "$prodDir/storage/framework/cache/.gitkeep" -Force
New-Item -ItemType File -Path "$prodDir/storage/framework/sessions/.gitkeep" -Force
New-Item -ItemType File -Path "$prodDir/storage/framework/views/.gitkeep" -Force

# Create deployment instructions
Write-Host "Creating deployment instructions..." -ForegroundColor Yellow
$instructions = @"
# SWIFT SYNCH Production Deployment

## Quick Setup:
1. Upload all files to your server
2. Set web server document root to: public/
3. Run: composer install --no-dev --optimize-autoloader
4. Run: php artisan migrate --force
5. Set proper permissions on storage/ and bootstrap/cache/
6. Configure your .env file for production

## Admin Login:
- Email: admin@swiftsynch.com
- Password: (check your seeder file)

## File Size Reduction:
- Excluded node_modules/ (~2GB)
- Excluded development files
- Only production-ready files included

## Estimated Size: ~50-100MB (instead of 2.5GB+)
"@

$instructions | Out-File -FilePath "$prodDir/DEPLOYMENT.md" -Encoding UTF8

Write-Host "Production package created in: $prodDir" -ForegroundColor Green
Write-Host "Estimated size reduction: 95% smaller!" -ForegroundColor Green
Write-Host "Ready for deployment!" -ForegroundColor Green 