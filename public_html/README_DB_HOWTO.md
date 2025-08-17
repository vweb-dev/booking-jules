# Database Setup and Maintenance

This document provides instructions for setting up, managing, and understanding the database schema for the Luxury Talent Booking (RCE) application.

## Automatic Setup (Recommended)

The recommended way to set up the database is to use the web-based installer located at `/setup`. When you run the installer, it will automatically perform the following steps:
1.  Ask for your database credentials.
2.  Connect to your database server.
3.  Create the application database if it doesn't exist.
4.  Import the complete schema from `db/schema.sql`.
5.  Import the initial seed data from `db/seeds.sql`.

There is no need for manual database interaction if the setup wizard completes successfully.

## Manual Setup

If the web installer fails or if you prefer to set up the database manually, you can follow these steps.

### Using the `mysql` Command Line

1.  **Log in to MySQL:**
    ```bash
    mysql -u your_username -p
    ```
2.  **Create the database:**
    ```sql
    CREATE DATABASE your_dbname;
    ```
3.  **Select the database:**
    ```sql
    USE your_dbname;
    ```
4.  **Import the schema:**
    ```sql
    source /path/to/your/public_html/db/schema.sql;
    ```
5.  **Import the seed data:**
    ```sql
    source /path/to/your/public_html/db/seeds.sql;
    ```

### Using phpMyAdmin

1.  Create a new database in your cPanel.
2.  Select the new database in the phpMyAdmin sidebar.
3.  Click the "Import" tab.
4.  Upload and import the `db/schema.sql` file.
5.  After the schema is imported, click the "Import" tab again.
6.  Upload and import the `db/seeds.sql` file.

## Default Users

The seed data (`db/seeds.sql`) creates four default users to get you started.

**Universal Password:** `password123`

| Email                   | Role           | Description                                    |
| ----------------------- | -------------- | ---------------------------------------------- |
| `sa@luxetalent.app`     | Super Admin    | System-wide administrator. Not tied to a company. |
| `admin@elitemodel.com`  | Tenant Admin   | Admin for the "Elite Model Management" company. |
| `gisele@elitemodel.com` | Talent         | A sample talent profile.                       |
| `tom@brady.com`         | Client         | A sample client profile.                       |

## Schema Overview

The database is structured around a few key concepts:
- **`roles`, `users`, `companies`:** These tables manage access control and tenancy. A `user` has one `role` and belongs to one `company` (except for Super Admins).
- **`talent_profiles`:** Contains all the specific details about a talent user.
- **`talent_media`:** Stores paths to the images and videos uploaded by talent, along with their approval status.
- **`bookings`:** Tracks jobs between a `client` and a `talent`.
- **`event_broadcasts`:** Allows a Tenant Admin to define an event. The system is intended to then find matching talent and record their responses in `event_targets` and `event_responses`.
- **`status_posts`:** These are temporary media posts (like "stories") that are automatically deleted by a cron job after they expire.
