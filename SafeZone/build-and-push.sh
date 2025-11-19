#!/bin/bash

# SafeZone Production Build and Push Script
# Usage: ./build-and-push.sh [version]

set -e

# Load environment variables
if [ -f .env.production ]; then
    export $(cat .env.production | grep -v '^#' | xargs)
else
    echo "Error: .env.production file not found!"
    exit 1
fi

# Get version from argument or environment
VERSION=${1:-${VERSION:-latest}}
DOCKER_USERNAME=${DOCKER_USERNAME:-your_dockerhub_username}

echo "======================================"
echo "SafeZone Production Build & Push"
echo "======================================"
echo "Docker Username: $DOCKER_USERNAME"
echo "Version: $VERSION"
echo "======================================"

# Check if logged in to Docker Hub
echo "Checking Docker Hub authentication..."
docker info | grep Username || {
    echo "Please login to Docker Hub first:"
    docker login
}

echo ""
echo "Step 1/4: Building Laravel image..."
echo "======================================"
docker build \
    --platform linux/amd64 \
    -t ${DOCKER_USERNAME}/safezone-laravel:${VERSION} \
    -t ${DOCKER_USERNAME}/safezone-laravel:latest \
    -f SafeZone/Dockerfile \
    ./SafeZone

echo ""
echo "Step 2/4: Building Nginx image..."
echo "======================================"
docker build \
    --platform linux/amd64 \
    -t ${DOCKER_USERNAME}/safezone-nginx:${VERSION} \
    -t ${DOCKER_USERNAME}/safezone-nginx:latest \
    -f nginx/Dockerfile \
    ./nginx

echo ""
echo "Step 3/4: Building Node.js image..."
echo "======================================"
docker build \
    --platform linux/amd64 \
    -t ${DOCKER_USERNAME}/safezone-node:${VERSION} \
    -t ${DOCKER_USERNAME}/safezone-node:latest \
    -f node-server/Dockerfile \
    ./node-server

echo ""
echo "Step 4/4: Pushing images to Docker Hub..."
echo "======================================"
docker push ${DOCKER_USERNAME}/safezone-laravel:${VERSION}
docker push ${DOCKER_USERNAME}/safezone-laravel:latest
docker push ${DOCKER_USERNAME}/safezone-nginx:${VERSION}
docker push ${DOCKER_USERNAME}/safezone-nginx:latest
docker push ${DOCKER_USERNAME}/safezone-node:${VERSION}
docker push ${DOCKER_USERNAME}/safezone-node:latest

echo ""
echo "======================================"
echo "✅ Build and Push completed successfully!"
echo "======================================"
echo "Images pushed:"
echo "  - ${DOCKER_USERNAME}/safezone-laravel:${VERSION}"
echo "  - ${DOCKER_USERNAME}/safezone-nginx:${VERSION}"
echo "  - ${DOCKER_USERNAME}/safezone-node:${VERSION}"
echo ""
echo "Next steps:"
echo "1. Copy .env.production to server"
echo "2. Copy docker-compose.prod.yml to server"
echo "3. Run: docker-compose -f docker-compose.prod.yml up -d"
echo "======================================"
