# SafeZone Production Build and Push Script (PowerShell)
# Usage: .\build-and-push.ps1 [version]

param(
    [string]$Version = "latest"
)

$ErrorActionPreference = "Stop"

Write-Host "======================================" -ForegroundColor Cyan
Write-Host "SafeZone Production Build & Push" -ForegroundColor Cyan
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
    Write-Host "Error: .env.production file not found!" -ForegroundColor Red
    exit 1
}

$DockerUsername = $env:DOCKER_USERNAME
if ([string]::IsNullOrEmpty($DockerUsername)) {
    Write-Host "Error: DOCKER_USERNAME not set in .env.production" -ForegroundColor Red
    exit 1
}

if ($Version -eq "latest" -and $env:VERSION) {
    $Version = $env:VERSION
}

Write-Host "Docker Username: $DockerUsername" -ForegroundColor Green
Write-Host "Version: $Version" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Cyan

# Check Docker authentication
Write-Host "`nChecking Docker Hub authentication..." -ForegroundColor Yellow
try {
    $dockerInfoOutput = docker info 2>&1 | Out-String
    $isLoggedIn = $dockerInfoOutput -match "Username:"
    
    if (-not $isLoggedIn) {
        Write-Host "Not logged in to Docker Hub." -ForegroundColor Yellow
        Write-Host "Please login with your Docker Hub credentials:" -ForegroundColor Yellow
        docker login
        if ($LASTEXITCODE -ne 0) {
            Write-Host "Error: Docker login failed!" -ForegroundColor Red
            exit 1
        }
    } else {
        Write-Host "Already logged in to Docker Hub." -ForegroundColor Green
    }
} catch {
    Write-Host "Warning: Could not verify Docker authentication, continuing..." -ForegroundColor Yellow
}

# Build Laravel image
Write-Host "`nStep 1/4: Building Laravel image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-laravel:${Version}" `
    -t "${DockerUsername}/safezone-laravel:latest" `
    -f SafeZone/Dockerfile `
    ./SafeZone

# Build Nginx image
Write-Host "`nStep 2/4: Building Nginx image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-nginx:${Version}" `
    -t "${DockerUsername}/safezone-nginx:latest" `
    -f nginx/Dockerfile `
    ./nginx

# Build Node.js image
Write-Host "`nStep 3/4: Building Node.js image..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker build `
    --platform linux/amd64 `
    -t "${DockerUsername}/safezone-node:${Version}" `
    -t "${DockerUsername}/safezone-node:latest" `
    -f node-server/Dockerfile `
    ./node-server

# Push images
Write-Host "`nStep 4/4: Pushing images to Docker Hub..." -ForegroundColor Yellow
Write-Host "======================================" -ForegroundColor Cyan
docker push "${DockerUsername}/safezone-laravel:${Version}"
docker push "${DockerUsername}/safezone-laravel:latest"
docker push "${DockerUsername}/safezone-nginx:${Version}"
docker push "${DockerUsername}/safezone-nginx:latest"
docker push "${DockerUsername}/safezone-node:${Version}"
docker push "${DockerUsername}/safezone-node:latest"

Write-Host "`n======================================" -ForegroundColor Green
Write-Host "✅ Build and Push completed successfully!" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Green
Write-Host "Images pushed:" -ForegroundColor Cyan
Write-Host "  - ${DockerUsername}/safezone-laravel:${Version}" -ForegroundColor White
Write-Host "  - ${DockerUsername}/safezone-nginx:${Version}" -ForegroundColor White
Write-Host "  - ${DockerUsername}/safezone-node:${Version}" -ForegroundColor White
Write-Host "`nNext steps:" -ForegroundColor Yellow
Write-Host "1. Copy .env.production to server" -ForegroundColor White
Write-Host "2. Copy docker-compose.prod.yml to server" -ForegroundColor White
Write-Host "3. Run: docker-compose -f docker-compose.prod.yml up -d" -ForegroundColor White
Write-Host "======================================" -ForegroundColor Green
