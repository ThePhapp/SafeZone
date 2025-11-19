#!/bin/bash

# Server-side deployment script
# Run this on production server after copying files

set -e

echo "======================================"
echo "SafeZone Production Deployment"
echo "======================================"

# Check if .env.production exists
if [ ! -f .env.production ]; then
    echo "Error: .env.production not found!"
    echo "Please copy .env.production to this directory first."
    exit 1
fi

# Load environment variables
export $(cat .env.production | grep -v '^#' | xargs)

echo "Project: SafeZone"
echo "Version: ${VERSION:-latest}"
echo "Docker Username: ${DOCKER_USERNAME}"
echo "======================================" echo ""

# Login to Docker Hub
echo "Logging in to Docker Hub..."
docker login

# Pull latest images
echo ""
echo "Pulling Docker images..."
docker-compose -f docker-compose.prod.yml pull

# Stop existing containers
echo ""
echo "Stopping existing containers..."
docker-compose -f docker-compose.prod.yml down

# Start services
echo ""
echo "Starting services..."
docker-compose -f docker-compose.prod.yml up -d

# Wait for services to be healthy
echo ""
echo "Waiting for services to start..."
sleep 20

# Check health
echo ""
echo "Checking service health..."
docker-compose -f docker-compose.prod.yml ps

# Run migrations (if needed)
read -p "Run database migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Running migrations..."
    docker-compose -f docker-compose.prod.yml exec -T laravel php artisan migrate --force
fi

# Cache configuration
echo ""
echo "Caching configuration..."
docker-compose -f docker-compose.prod.yml exec -T laravel php artisan config:cache
docker-compose -f docker-compose.prod.yml exec -T laravel php artisan route:cache
docker-compose -f docker-compose.prod.yml exec -T laravel php artisan view:cache

echo ""
echo "======================================"
echo "✅ Deployment completed!"
echo "======================================"
echo ""
echo "Access your application at:"
echo "  HTTP:  http://$(hostname -I | awk '{print $1}'):${NGINX_HTTP_PORT:-8080}"
echo "  HTTPS: https://$(hostname -I | awk '{print $1}'):${NGINX_HTTPS_PORT:-8443}"
echo ""
echo "Check logs with:"
echo "  docker-compose -f docker-compose.prod.yml logs -f"
echo ""
echo "======================================"
