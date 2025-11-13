# SafeZone Docker Setup with Nginx

## Cấu trúc

```
SafeZoneVN/
├── docker-compose.yml          # Orchestration file
├── SafeZone/
│   ├── Dockerfile             # PHP-FPM image
│   └── ...
├── node-server/
│   ├── Dockerfile             # Node.js image
│   └── ...
└── nginx/
    ├── Dockerfile             # Nginx image
    ├── nginx.conf             # Main config
    └── conf.d/
        └── default.conf       # Site config
```

## Các Services

| Service         | Port            | Vai trò                  |
| --------------- | --------------- | ------------------------ |
| **nginx**       | 80, 443         | Web server reverse proxy |
| **laravel**     | 9000 (internal) | PHP-FPM backend          |
| **node-server** | 6001            | Real-time WebSocket      |
| **mysql**       | 3307            | Database                 |

## Cách sử dụng

### Build & Start

```bash
# Build images
docker-compose build

# Start all services
docker-compose up -d

# View logs
docker-compose logs -f
```

### Truy cập ứng dụng

- **Web Application**: http://localhost
- **Node.js Server**: http://localhost:6001
- **MySQL**: localhost:3307

### Thực thi lệnh

```bash
# Artisan commands
docker-compose exec laravel php artisan migrate
docker-compose exec laravel php artisan cache:clear
docker-compose exec laravel php artisan tinker

# Node.js commands
docker-compose exec node-server npm install

# MySQL commands
docker-compose exec mysql mysql -u root -p SafeZone
```

### Dừng services

```bash
docker-compose down

# Xóa volumes (databases)
docker-compose down -v
```

## Cấu hình Nginx

File cấu hình nằm tại `nginx/conf.d/default.conf`:

- **Root directory**: `/var/www/public`
- **PHP-FPM**: `laravel:9000`
- **Cache**: Static files được cache 1 năm
- **Security**: Headers, .env protection, .git protection
- **Gzip**: Compression bật

## Environment Variables

Cập nhật trong `.env` (SafeZone folder):

```env
APP_ENV=local
APP_DEBUG=true
DB_HOST=mysql
DB_DATABASE=SafeZone
DB_USERNAME=root
DB_PASSWORD=123456
```

## Production Setup

Tạo `docker-compose.prod.yml`:

```yaml
version: "3.9"

services:
  laravel:
    environment:
      APP_ENV: production
      APP_DEBUG: false

  nginx:
    volumes:
      - ./nginx/ssl:/etc/nginx/ssl:ro # SSL certificates

  mysql:
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
```

Chạy:

```bash
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## Troubleshooting

### Port 80 already in use

```bash
# Thay đổi port trong docker-compose.yml
ports:
  - "8080:80"
```

### Permission denied storage folder

```bash
docker-compose exec laravel chown -R www-data:www-data /var/www
```

### MySQL connection error

```bash
# Kiểm tra MySQL logs
docker-compose logs mysql

# Restart MySQL
docker-compose restart mysql
```

## Performance Tips

1. **Use volume cached for development**:

   ```yaml
   volumes:
     - ./SafeZone:/var/www:cached
   ```

2. **Enable query caching**:

   ```bash
   docker-compose exec laravel php artisan config:cache
   ```

3. **Monitor resource usage**:
   ```bash
   docker stats
   ```
