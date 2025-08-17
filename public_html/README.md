# Luxury Talent Booking — Red Carpet Edition (RCE)

Welcome to the Luxury Talent Booking (RCE) application. This document provides an overview of the project, setup instructions, and other relevant details.

## Overview

Luxury Talent Booking (RCE) is a cPanel-deployable Progressive Web App (PWA) built with pure PHP 8+ and MySQL. It is designed as a single-tenant solution for talent agencies, providing a "reels-first" user experience for clients and comprehensive management tools for administrators and talent.

The application is built to be dropped into a standard shared hosting environment with zero Node.js dependencies.

## Key Features

- **Progressive Web App (PWA):** Installable on mobile devices with offline caching for static assets.
- **Role-Based Access Control:** Four distinct user roles (Super Admin, Tenant Admin, Talent, Client) with protected dashboards.
- **Reels-First UX:** A modern, engaging interface for clients to browse talent.
- **Media Management:** Strict 9:16 media policy with a built-in validator for images.
- **Event Broadcasting:** Allows tenant admins to send targeted event opportunities to talent.
- **Easy Installation:** A simple web-based setup wizard to configure the application.
- **Secure by Default:** The installer self-destructs, and sensitive directories are protected.

## Server Requirements

- Apache Web Server with `mod_rewrite` enabled.
- PHP 8.0 or higher.
- MySQL 5.7 or higher (or MariaDB equivalent).
- PDO, GD, and finfo PHP extensions.

## Installation

1.  **Upload Files:** Upload the contents of the `public_html` directory to your server's document root (which is often also named `public_html`).
2.  **Create a Database:** Using your hosting control panel (e.g., cPanel), create a new MySQL database and a database user with full privileges on that database.
3.  **Run the Setup Wizard:** Navigate to `http://your-domain.com/setup` in your web browser.
4.  **Enter Details:** Fill in your database credentials (host, name, user, password) and the Application URL.
5.  **Install:** Click "Install Now". The wizard will configure the application, import the database schema, and delete the `/setup` directory.
6.  **Done!** You will be redirected to the homepage of your new installation.

## Cron Job Setup

The application relies on two cron jobs to handle routine tasks. You need to add these to your server's cron schedule (usually via the cPanel "Cron Jobs" interface).

**Note:** The exact path to PHP and your application may vary. Please adjust accordingly. It is recommended to run these jobs every 5 minutes.

```bash
# Clean up expired status posts (stories)
*/5 * * * * /usr/bin/php /home/your_user/public_html/cron/cleanup_status.php >> /home/your_user/public_html/logs/cron.log 2>&1

# Mark expired event broadcasts
*/5 * * * * /usr/bin/php /home/your_user/public_html/cron/close_expired_broadcasts.php >> /home/your_user/public_html/logs/cron.log 2>&1
```

## Security

- The `/setup` directory automatically deletes itself upon successful installation. If it fails to delete, you **must** remove it manually.
- The `/config`, `/db`, and `/cron` directories are protected from direct web access by `.htaccess` rules.
- Passwords are securely hashed using bcrypt.
- The application uses session regeneration and other measures to protect against common vulnerabilities.
