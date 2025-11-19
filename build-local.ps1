# SafeZone Local Build Script (PowerShell)
# Build Docker images locally without pushing to Docker Hub
# Usage: .\build-local.ps1 [version]

param(
    [string]$Version = "latest"
)

$ErrorActionPreference = "Stop"

Write-Host "======================================" -ForegroundColor Cyan
Write-Host "SafeZone Local Build (No Push)" -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Cyan

# Load environment variables from .env.production
if (Test-Path .env.production) {
    Get-Content .env.production | ForEach-Object {
        if ($_ -match '^([^#][^=]+)=(.*)$') {
            $name = $matches[1].Trim()
            $value = $matches[2].Trim()
            Set-Item -Path "env:$name" -Value $value
        }
    }
} else {
    Write-Host "Warning: .env.production file not found, using defaults" -ForegroundColor Yellow
}

$DockerUsername = if ($env:DOCKER_USERNAME) { $env:DOCKER_USERNAME } else { "safezone" }

if ($Version -eq "latest" -and $env:VERSION) {
    $Version = $env:VERSION
}

Write-Host "Docker Username: $DockerUsername" -ForegroundColor Green
Write-Host "Version: $Version" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Cyan

# Build Laravel image
Write-Host "`nStep 1/3: Building Laravel image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-laravel:${Version}" `
    -t "${DockerUsername}/safezone-laravel:latest" `
    -f SafeZone/Dockerfile `
    ./SafeZone

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error building Laravel image" -ForegroundColor Red
    exit 1
}

# Build Nginx image
Write-Host "`nStep 2/3: Building Nginx image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-nginx:${Version}" `
    -t "${DockerUsername}/safezone-nginx:latest" `
    -f nginx/Dockerfile `
    ./nginx

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error building Nginx image" -ForegroundColor Red
    exit 1
}

# Build Node.js image
Write-Host "`nStep 3/3: Building Node.js image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-node:${Version}" `
    -t "${DockerUsername}/safezone-node:latest" `
    -f node-server/Dockerfile `
    ./node-server

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error building Node.js image" -ForegroundColor Red
    exit 1
}

Write-Host "`n======================================" -ForegroundColor Green
Write-Host "✅ Local Build completed successfully!" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Green
Write-Host "Images built:" -ForegroundColor Cyan
Write-Host "  - ${DockerUsername}/safezone-laravel:${Version}" -ForegroundColor White
Write-Host "  - ${DockerUsername}/safezone-nginx:${Version}" -ForegroundColor White
Write-Host "  - ${DockerUsername}/safezone-node:${Version}" -ForegroundColor White
Write-Host "`nNext steps:" -ForegroundColor Yellow
Write-Host "1. Test locally: docker-compose up -d" -ForegroundColor White
Write-Host "2. When ready to push: ./build-and-push.ps1" -ForegroundColor White
Write-Host "======================================" -ForegroundColor Green
