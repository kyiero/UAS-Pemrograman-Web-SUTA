# CMS Pengajian - Religious Study Content Management System

A comprehensive CMS built with CodeIgniter 3 for managing Islamic study content (kajian/pengajian), articles, schedules, and categories.

## Features

### Admin Panel
- **Dashboard**: Statistics and overview of content
- **Article Management**: Create, edit, delete articles with featured image support
- **Category Management**: Organize content by categories (Tafsir, Hadits, Fiqih, etc.)
- **Schedule Management**: Manage kajian/study schedules
- **User Management**: Admin, Author, and Viewer roles
- **Authentication**: Secure login system with role-based access

### Frontend
- **Homepage**: Featured and recent articles
- **Articles Listing**: Browse all articles with pagination
- **Article Detail**: Full article view with related articles
- **Category Pages**: Filter articles by category
- **Schedule Page**: View upcoming kajian schedules
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface

## Technology Stack

- **Framework**: CodeIgniter 3
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Server**: PHP 7.4, Apache
- **Containerization**: Docker & Docker Compose

## Installation

### Prerequisites
- Docker
- Docker Compose

### Quick Start

1. **Start Docker containers**:
   ```bash
   docker-compose up -d
   ```

2. **Import database**:
   ```bash
   docker exec -i cms-suta-db mysql -u cms_user -pcms_password cms_suta < database.sql
   ```

3. **Set permissions** (if needed):
   ```bash
   docker exec cms-suta-web chown -R www-data:www-data /var/www/html/uploads
   docker exec cms-suta-web chmod -R 755 /var/www/html/uploads
   ```

4. **Access the application**:
   - Frontend: http://localhost:8080
   - Admin Panel: http://localhost:8080/admin
   - phpMyAdmin: http://localhost:8081

### Default Credentials

**Admin Login**:
- Username: `admin`
- Password: `admin123`

**Database**:
- Host: `db` (in container) or `localhost` (from host)
- Port: `3306`
- Database: `cms_suta`
- Username: `cms_user`
- Password: `cms_password`
- Root Password: `root`

## Directory Structure

```
CMS-Suta/
├── application/
│   ├── controllers/
│   │   ├── admin/          # Admin controllers
│   │   │   ├── Auth.php
│   │   │   ├── Dashboard.php
│   │   │   ├── Articles.php
│   │   │   ├── Categories.php
│   │   │   ├── Schedules.php
│   │   │   └── Users.php
│   │   └── Welcome.php     # Frontend controller
│   ├── models/             # Data models
│   │   ├── User_model.php
│   │   ├── Article_model.php
│   │   ├── Category_model.php
│   │   ├── Schedule_model.php
│   │   └── Setting_model.php
│   ├── views/
│   │   ├── admin/          # Admin views
│   │   │   ├── auth/
│   │   │   ├── dashboard.php
│   │   │   ├── articles/
│   │   │   ├── categories/
│   │   │   ├── schedules/
│   │   │   ├── users/
│   │   │   └── templates/
│   │   └── frontend/       # Public views
│   │       ├── home.php
│   │       ├── articles.php
│   │       ├── article_detail.php
│   │       ├── category.php
│   │       ├── schedules.php
│   │       └── templates/
│   ├── core/
│   │   └── Admin_Controller.php  # Base admin controller
│   └── config/             # Configuration files
├── uploads/                # Uploaded files
├── database.sql            # Database schema and sample data
├── docker-compose.yml      # Docker configuration
├── Dockerfile              # Docker image definition
└── README.md              # This file
```

## Database Schema

### Tables
- **users**: User accounts with roles (admin, author, viewer)
- **categories**: Content categories
- **articles**: Main content with rich text, images, and status
- **schedules**: Kajian/study schedules with date, time, location
- **settings**: System settings

## Admin Panel Usage

### Dashboard
- View statistics (total articles, published articles, categories, schedules)
- Quick overview of recent articles and upcoming schedules

### Articles
- **Create**: Write new articles with rich content, featured image, category
- **Edit**: Update existing articles
- **Delete**: Remove articles
- **Status**: Draft, Published, Archived
- **Featured**: Mark articles as featured for homepage display

### Categories
- **CRUD operations**: Create, Read, Update, Delete categories
- **Icons**: FontAwesome icon support
- **Slugs**: Auto-generated URL-friendly slugs

### Schedules
- **Manage**: Create and edit kajian schedules
- **Details**: Title, Ustadz, location, date, time, duration
- **Status**: Active/Inactive

### Users
- **Create**: Add new users with roles
- **Roles**: 
  - Admin: Full access
  - Author: Can manage articles
  - Viewer: Read-only access
- **Edit**: Update user information
- **Delete**: Remove users (cannot delete yourself)

## User Roles & Permissions

### Admin
- Full access to all features
- Can manage users, categories, articles, schedules
- Can delete any content

### Author
- Can create, edit, and delete own articles
- Can manage schedules
- Cannot access user management or categories

### Viewer
- Cannot access admin panel
- Read-only access

## Docker Commands

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

### Access web container shell
```bash
docker exec -it cms-suta-web bash
```

### Access MySQL
```bash
docker exec -it cms-suta-db mysql -u cms_user -pcms_password cms_suta
```

### Rebuild containers
```bash
docker-compose up -d --build
```

### Import database
```bash
docker exec -i cms-suta-db mysql -u cms_user -pcms_password cms_suta < database.sql
```

### Backup database
```bash
docker exec cms-suta-db mysqldump -u cms_user -pcms_password cms_suta > backup.sql
```

## Customization

### Change Site Settings
1. Login to admin panel
2. Edit settings in database via phpMyAdmin
3. Or modify `Setting_model` to add admin interface

### Add New Categories
1. Navigate to Admin > Categories
2. Click "Create Category"
3. Fill in name, description, and FontAwesome icon class

### Upload Limits
- Maximum file size: 2MB
- Allowed types: JPG, JPEG, PNG, GIF
- Upload directory: `uploads/articles/`

## Troubleshooting

### Permission Issues
```bash
docker exec -it cms-suta-web chown -R www-data:www-data /var/www/html/application/logs
docker exec -it cms-suta-web chown -R www-data:www-data /var/www/html/application/cache
docker exec -it cms-suta-web chown -R www-data:www-data /var/www/html/uploads
```

### Database Connection Failed
- Verify containers are running: `docker-compose ps`
- Check database credentials in `application/config/database.php`
- Ensure hostname is set to `db` (not `localhost`)

### Cannot Login
- Verify database is imported correctly
- Check default credentials: admin / admin123
- Reset admin password in phpMyAdmin if needed

### 404 Errors
- Verify `.htaccess` file exists in root directory
- Check Apache mod_rewrite is enabled (should be in Dockerfile)
- Verify routes in `application/config/routes.php`

## Security Notes

### For Production
1. **Change all default passwords**
2. **Remove phpMyAdmin** or secure it
3. **Enable HTTPS/SSL**
4. **Update secret keys** in config
5. **Disable database debugging**
6. **Set proper file permissions**
7. **Enable CSRF protection** (already enabled)
8. **Regular backups**

## Support

For issues or questions, please check:
- CodeIgniter 3 Documentation: https://codeigniter.com/userguide3/
- Bootstrap 5 Documentation: https://getbootstrap.com/docs/5.3/
- Docker Documentation: https://docs.docker.com/

## License

This project is open-source and available for educational purposes.

## Credits

- **Framework**: CodeIgniter 3
- **UI**: Bootstrap 5
- **Icons**: Font Awesome 6
- **Database**: MySQL 8.0

---

**Version**: 1.0.0
**Last Updated**: January 2026
