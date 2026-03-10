<?php
/**
 * WordPress Configuration File
 *
 * This file is used instead of the default wp-config.php to provide
 * better control over WordPress configuration in Docker environments.
 *
 * @package WordPress
 */

// ** Database settings ** //
define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress');
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress');
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress');
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'mariadb:3306');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// ** Authentication Unique Keys and Salts ** //
// You can generate these using: https://api.wordpress.org/secret-key/1.1/salt/
//define('AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY') ?: 'put your unique phrase here');
//define('SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY') ?: 'put your unique phrase here');
//define('LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY') ?: 'put your unique phrase here');
//define('NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY') ?: 'put your unique phrase here');
//define('AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT') ?: 'put your unique phrase here');
//define('SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') ?: 'put your unique phrase here');
//define('LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT') ?: 'put your unique phrase here');
//define('NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT') ?: 'put your unique phrase here');

// ** WordPress Database Table prefix ** //
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// ** WordPress debugging mode ** //
define('WP_DEBUG', filter_var(getenv('WORDPRESS_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_LOG', filter_var(getenv('WORDPRESS_DEBUG_LOG') ?: false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_DISPLAY', filter_var(getenv('WORDPRESS_DEBUG_DISPLAY') ?: false, FILTER_VALIDATE_BOOLEAN));
define('SCRIPT_DEBUG', filter_var(getenv('SCRIPT_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN));

// ** Site URL Configuration ** //
$site_url = getenv('WORDPRESS_SITE_URL') ?: 'http://localhost:8080';
define('WP_HOME', $site_url);
define('WP_SITEURL', $site_url);

// ** File System Method ** //
// Direct file system access for plugin/theme installation
define('FS_METHOD', 'direct');

// ** Memory Limits ** //
define('WP_MEMORY_LIMIT', getenv('WP_MEMORY_LIMIT') ?: '256M');
define('WP_MAX_MEMORY_LIMIT', getenv('WP_MAX_MEMORY_LIMIT') ?: '512M');

// ** Auto-save Interval ** //
define('AUTOSAVE_INTERVAL', 300); // 5 minutes

// ** Post Revisions ** //
define('WP_POST_REVISIONS', getenv('WP_POST_REVISIONS') ?: 5);

// ** Automatic Updates ** //
define('AUTOMATIC_UPDATER_DISABLED', filter_var(getenv('AUTOMATIC_UPDATER_DISABLED') ?: true, FILTER_VALIDATE_BOOLEAN));
define('WP_AUTO_UPDATE_CORE', filter_var(getenv('WP_AUTO_UPDATE_CORE') ?: false, FILTER_VALIDATE_BOOLEAN));

// ** Security Headers ** //
define('DISALLOW_FILE_EDIT', filter_var(getenv('DISALLOW_FILE_EDIT') ?: false, FILTER_VALIDATE_BOOLEAN));
define('DISALLOW_FILE_MODS', filter_var(getenv('DISALLOW_FILE_MODS') ?: false, FILTER_VALIDATE_BOOLEAN));

// ** SSL/HTTPS Configuration ** //
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// ** Redis Cache Configuration (optional) ** //
if (getenv('WORDPRESS_REDIS_HOST')) {
    define('WP_REDIS_HOST', getenv('WORDPRESS_REDIS_HOST'));
    define('WP_REDIS_PORT', getenv('WORDPRESS_REDIS_PORT') ?: 6379);
    define('WP_REDIS_PASSWORD', getenv('WORDPRESS_REDIS_PASSWORD') ?: '');
    define('WP_REDIS_DATABASE', getenv('WORDPRESS_REDIS_DATABASE') ?: 0);
    define('WP_CACHE_KEY_SALT', getenv('WORDPRESS_REDIS_KEY_SALT') ?: 'wordpress_');
}

// ** Custom Content Directory (optional) ** //
// Uncomment if you want to use a custom wp-content location
// define('WP_CONTENT_DIR', '/var/www/html/wp-content');
// define('WP_CONTENT_URL', WP_HOME . '/wp-content');

// ** Multisite Configuration (optional) ** //
// Uncomment and configure if using WordPress Multisite
// define('WP_ALLOW_MULTISITE', true);
// define('MULTISITE', true);
// define('SUBDOMAIN_INSTALL', false);
// define('DOMAIN_CURRENT_SITE', 'localhost');
// define('PATH_CURRENT_SITE', '/');
// define('SITE_ID_CURRENT_SITE', 1);
// define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
