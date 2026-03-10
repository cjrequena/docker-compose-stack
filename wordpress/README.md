# WordPress Docker Stack

A production-ready WordPress development environment using Docker Compose with MariaDB, WP-CLI, and Adminer.

## Features

- WordPress with Apache and PHP 8.3
- Custom wp-config.php with environment variable support
- MariaDB database with health checks
- WP-CLI for command-line management
- Adminer for database administration
- Network segmentation (internal backend, public frontend)
- Resource limits and health checks
- Persistent data volumes
- Security keys and advanced configuration options

## Quick Start

1. **Add mysite.test to your hosts file:**
   
   On macOS/Linux:
   ```bash
   sudo nano /etc/hosts
   ```
   
   Add this line:
   ```
   127.0.0.1 mysite.test
   ```
   
   Save and exit (Ctrl+O, Enter, Ctrl+X in nano)

2. **Configure environment variables:**
   ```bash
   # Edit .env file with your settings
   nano .env
   ```

3. **Start the stack:**
   ```bash
   docker compose up -d
   ```

4. **Install WordPress using WP-CLI:**
   ```bash
   docker compose run --rm wpcli wp core install \
     --url="http://mysite.test:800" \
     --title="My WordPress Site" \
     --admin_user="admin" \
     --admin_password="admin" \
     --admin_email="admin@example.com"
   ```
   
   Note: The "sendmail: can't connect" warning is normal for local development.

5. **Access WordPress:**
   - WordPress: http://mysite.test:8080
   - Admin Panel: http://mysite.test:8080/wp-admin
   - Adminer (DB): http://localhost:8081
   - Login: admin / admin

6. **Optional: Change admin password:**
   ```bash
   docker compose run --rm wpcli wp user update admin --user_pass="your-secure-password"
   ```

## WP-CLI Usage

Run WordPress commands using WP-CLI:

```bash
# Install WordPress via CLI
docker compose run --rm wpcli wp core install \
  --url="${WORDPRESS_SITE_URL}" \
  --title="${WORDPRESS_SITE_TITLE}" \
  --admin_user="${WORDPRESS_ADMIN_USER}" \
  --admin_password="${WORDPRESS_ADMIN_PASSWORD}" \
  --admin_email="${WORDPRESS_ADMIN_EMAIL}"

# List installed plugins
docker compose run --rm wpcli wp plugin list

# Install and activate a plugin
docker compose run --rm wpcli wp plugin install contact-form-7 --activate

# Update WordPress core
docker compose run --rm wpcli wp core update

# Create a new user
docker compose run --rm wpcli wp user create editor editor@example.com --role=editor

# Export database
docker compose run --rm wpcli wp db export - > backup.sql

# Import database
docker compose run --rm wpcli wp db import - < backup.sql
```

## Database Management

Access Adminer at http://localhost:8081

- **System:** MySQL
- **Server:** mariadb
- **Username:** wordpress (or root)
- **Password:** wordpress (or root password from .env)
- **Database:** wordpress

## Environment Variables

Key variables in `.env`:

```bash
# Database
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=wordpress

# WordPress
WORDPRESS_PORT=8080
WORDPRESS_SITE_URL=http://mysite.test:8080
WORDPRESS_DEBUG=0
WORDPRESS_DEBUG_LOG=0
WORDPRESS_DEBUG_DISPLAY=0

# Performance
WP_MEMORY_LIMIT=256M
WP_MAX_MEMORY_LIMIT=512M
WP_POST_REVISIONS=5

# Security
DISALLOW_FILE_EDIT=0          # Set to 1 to disable theme/plugin editor
DISALLOW_FILE_MODS=0          # Set to 1 to disable all file modifications
AUTOMATIC_UPDATER_DISABLED=1  # Disable automatic updates
WP_AUTO_UPDATE_CORE=0         # Disable core auto-updates

# Admin credentials (for WP-CLI installation)
WORDPRESS_ADMIN_USER=admin
WORDPRESS_ADMIN_PASSWORD=admin
WORDPRESS_ADMIN_EMAIL=admin@example.com
```

### Security Keys

For production, generate unique security keys at https://api.wordpress.org/secret-key/1.1/salt/ and add them to `.env`:

```bash
WORDPRESS_AUTH_KEY=your-unique-key-here
WORDPRESS_SECURE_AUTH_KEY=your-unique-key-here
WORDPRESS_LOGGED_IN_KEY=your-unique-key-here
WORDPRESS_NONCE_KEY=your-unique-key-here
WORDPRESS_AUTH_SALT=your-unique-salt-here
WORDPRESS_SECURE_AUTH_SALT=your-unique-salt-here
WORDPRESS_LOGGED_IN_SALT=your-unique-salt-here
WORDPRESS_NONCE_SALT=your-unique-salt-here
```

## Services

### WordPress
- **Container:** wordpress_app
- **Port:** 80 (mapped to host port 80)
- **Domain:** mysite.test
- **Image:** wordpress:php8.3-apache
- **Resources:** 1 CPU, 256MB RAM

### MariaDB
- **Container:** wordpress_db
- **Port:** 3306 (internal only)
- **Image:** mariadb:lts
- **Resources:** 1 CPU, 512MB RAM

### WP-CLI
- **Container:** wordpress_cli
- **Usage:** One-off commands only
- **Image:** wordpress:cli

### Adminer
- **Container:** wordpress_adminer
- **Port:** 8081
- **Image:** adminer:latest
- **Resources:** 0.5 CPU, 128MB RAM

## Volumes

- `wordpress_mariadb_data` - Database files
- `wordpress_html` - WordPress core files and wp-content (themes, plugins, uploads)

## Custom Configuration

The stack uses a custom `wp-config.php` file located at `provision/wordpress/wp-config.php`. This file:

- Reads all configuration from environment variables
- Supports Redis caching (optional)
- Includes security headers and SSL detection
- Provides memory limits and performance tuning
- Supports WordPress Multisite (commented out by default)

You can modify this file to add custom WordPress constants or configurations.

## Networks

- `wordpress-backend` (172.28.0.0/24) - Internal network for database
- `wordpress-frontend` (172.29.0.0/24) - Public network for web access

## Common Tasks

### Stop the stack
```bash
docker compose down
```

### Stop and remove volumes (⚠️ deletes all data)
```bash
docker compose down -v
```

### View logs
```bash
docker compose logs -f wordpress
docker compose logs -f mariadb
```

### Restart a service
```bash
docker compose restart wordpress
```

### Access WordPress container shell
```bash
docker compose exec wordpress bash
```

### Backup database
```bash
docker compose exec mariadb mysqldump -u wordpress -pwordpress wordpress > backup.sql
```

### Restore database
```bash
docker compose exec -T mariadb mysql -u wordpress -pwordpress wordpress < backup.sql
```

## Troubleshooting

### WordPress shows database connection error
- Check if MariaDB is healthy: `docker compose ps`
- Verify environment variables in `.env`
- Check logs: `docker compose logs mariadb`

### Port already in use
- Change `WORDPRESS_PORT` in `.env` to another port (e.g., 8080)
- Update `WORDPRESS_SITE_URL` to match (e.g., http://mysite.test:8080)
- Or stop the conflicting service

### Permission issues
- WP-CLI runs as user 33:33 (www-data)
- Ensure volumes have correct permissions

### Reset everything
```bash
docker compose down -v
docker compose up -d
```

## Security Notes

- Change default passwords in `.env` before production use
- The backend network is isolated from external access
- Consider using secrets management for production
- Enable HTTPS with a reverse proxy (nginx, Traefik, Caddy)

## Production Considerations

For production deployments:

1. Use strong passwords
2. Enable HTTPS with SSL certificates
3. Configure regular backups
4. Set `WORDPRESS_DEBUG=0`
5. Use specific version tags instead of `latest`
6. Implement proper monitoring and logging
7. Consider using managed database services
8. Add Redis for object caching

## License

This configuration is provided as-is for development purposes.
