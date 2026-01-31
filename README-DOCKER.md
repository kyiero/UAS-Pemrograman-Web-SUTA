# Docker Setup for CMS-Suta

This project includes Docker configuration for easy development and deployment.

## Prerequisites

- Docker
- Docker Compose

## Services

The Docker setup includes three services:

1. **Web Server** (Apache with PHP 7.4) - Port 8080
2. **MySQL Database** (MySQL 8.0) - Port 3306
3. **phpMyAdmin** - Port 8081

## Quick Start

1. **Start the containers:**
   ```bash
   docker-compose up -d
   ```

2. **Update database configuration:**
   Edit `application/config/database.php`:
   ```php
   $db['default'] = array(
       'dsn'      => '',
       'hostname' => 'db',
       'username' => 'cms_user',
       'password' => 'cms_password',
       'database' => 'cms_suta',
       'dbdriver' => 'mysqli',
       // ... other settings
   );
   ```

3. **Access the application:**
   - Website: http://localhost:8080
   - phpMyAdmin: http://localhost:8081
     - Username: `root` or `cms_user`
     - Password: `root` or `cms_password`

## Useful Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f
```

### Restart containers
```bash
docker-compose restart
```

### Access web container shell
```bash
docker exec -it cms-suta-web bash
```

### Access MySQL container
```bash
docker exec -it cms-suta-db mysql -u root -p
```

### Rebuild containers
```bash
docker-compose up -d --build
```

## Database Credentials

- **Database Name:** cms_suta
- **Root Password:** root
- **Username:** cms_user
- **Password:** cms_password
- **Host:** db (when connecting from application)
- **Host:** localhost (when connecting from host machine)

## Troubleshooting

### Permission Issues
If you encounter permission issues with logs or cache:
```bash
docker exec -it cms-suta-web chown -R www-data:www-data /var/www/html/application/logs
docker exec -it cms-suta-web chown -R www-data:www-data /var/www/html/application/cache
```

### Database Connection Issues
Make sure the database hostname in `application/config/database.php` is set to `db` (the service name in docker-compose.yml).

### Port Conflicts
If ports 8080, 3306, or 8081 are already in use, you can modify them in `docker-compose.yml`.

## Production Notes

For production deployment:
1. Change all default passwords
2. Remove phpMyAdmin service or secure it
3. Configure proper environment variables
4. Set up proper SSL/TLS certificates
5. Configure backup strategy for the database volume
