#!/bin/bash

# CMS Pengajian Setup Script
# This script sets up the complete environment

echo "======================================"
echo "  CMS Pengajian Setup Script"
echo "======================================"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}Error: Docker is not running. Please start Docker first.${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Starting Docker containers...${NC}"
docker-compose up -d

echo ""
echo -e "${YELLOW}Step 2: Waiting for MySQL to be ready...${NC}"
sleep 10

# Test MySQL connection
until docker exec cms-suta-db mysql -u cms_user -pcms_password -e "SELECT 1" > /dev/null 2>&1; do
    echo "  Waiting for MySQL..."
    sleep 3
done

echo -e "${GREEN}  MySQL is ready!${NC}"

echo ""
echo -e "${YELLOW}Step 3: Importing database...${NC}"
docker exec -i cms-suta-db mysql -u cms_user -pcms_password cms_suta < database.sql 2>&1 | grep -v "Warning"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}  Database imported successfully!${NC}"
else
    echo -e "${RED}  Error importing database${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 4: Setting up file permissions...${NC}"
docker exec cms-suta-web bash -c "mkdir -p /var/www/html/uploads/articles"
docker exec cms-suta-web bash -c "chown -R www-data:www-data /var/www/html/uploads"
docker exec cms-suta-web bash -c "chmod -R 755 /var/www/html/uploads"
docker exec cms-suta-web bash -c "chown -R www-data:www-data /var/www/html/application/cache"
docker exec cms-suta-web bash -c "chown -R www-data:www-data /var/www/html/application/logs"

echo -e "${GREEN}  Permissions set successfully!${NC}"

echo ""
echo -e "${YELLOW}Step 5: Verifying installation...${NC}"

# Check tables
TABLES=$(docker exec cms-suta-db mysql -u cms_user -pcms_password cms_suta -e "SHOW TABLES;" 2>&1 | grep -v "Warning" | tail -n +2 | wc -l)
if [ "$TABLES" -eq 5 ]; then
    echo -e "${GREEN}  ✓ Database tables created (5/5)${NC}"
else
    echo -e "${RED}  ✗ Database tables incomplete${NC}"
fi

# Check admin user
ADMIN=$(docker exec cms-suta-db mysql -u cms_user -pcms_password cms_suta -e "SELECT username FROM users WHERE role='admin' LIMIT 1;" 2>&1 | grep -v "Warning" | tail -n 1)
if [ "$ADMIN" = "admin" ]; then
    echo -e "${GREEN}  ✓ Admin user created${NC}"
else
    echo -e "${RED}  ✗ Admin user not found${NC}"
fi

# Check web server
HTTP_CODE=$(docker exec cms-suta-web curl -s -o /dev/null -w "%{http_code}" http://localhost/)
if [ "$HTTP_CODE" = "200" ]; then
    echo -e "${GREEN}  ✓ Web server responding${NC}"
else
    echo -e "${RED}  ✗ Web server not responding${NC}"
fi

echo ""
echo "======================================"
echo -e "${GREEN}  Setup Complete!${NC}"
echo "======================================"
echo ""
echo "Access your application:"
echo ""
echo -e "  ${YELLOW}Frontend:${NC}   http://localhost:8080"
echo -e "  ${YELLOW}Admin:${NC}      http://localhost:8080/admin"
echo -e "  ${YELLOW}phpMyAdmin:${NC} http://localhost:8081"
echo ""
echo "Default Admin Credentials:"
echo -e "  ${YELLOW}Username:${NC} admin"
echo -e "  ${YELLOW}Password:${NC} admin123"
echo ""
echo "Database Credentials:"
echo -e "  ${YELLOW}Host:${NC}     db (in container) or localhost (from host)"
echo -e "  ${YELLOW}Port:${NC}     3306"
echo -e "  ${YELLOW}Database:${NC} cms_suta"
echo -e "  ${YELLOW}Username:${NC} cms_user"
echo -e "  ${YELLOW}Password:${NC} cms_password"
echo ""
echo "Useful commands:"
echo "  Stop:    docker-compose down"
echo "  Logs:    docker-compose logs -f"
echo "  Restart: docker-compose restart"
echo ""
echo -e "${GREEN}Happy coding!${NC}"
echo ""
