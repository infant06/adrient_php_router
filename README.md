# Sansia NGO Website

A comprehensive website for managing an NGO's online presence, including blog posts, events, services, and contact information.

## Project Overview

This project provides a complete web solution for non-governmental organizations (NGOs) with both a public-facing website and an administration panel to manage all content.

## Features

- Responsive front-end design
- Administrative dashboard
- Blog management system
- Events calendar
- Services showcase
- Contact form with submissions management
- User management system
- SEO optimization tools
- Profile management
- Settings management (general, social media, email)

## Project Structure

```
sansia-ngo/
├── admin/                  # Admin panel files
│   ├── blogs.php           # Blog management
│   ├── categories.php      # Category management
│   ├── contact.php         # Contact form submissions
│   ├── events.php          # Events management
│   ├── function.php        # Admin functionality
│   ├── index.php           # Admin dashboard
│   ├── login.php           # Admin login
│   ├── profile.php         # User profile management
│   ├── register.php        # User registration (should be removed in production)
│   ├── services.php        # Services management
│   ├── settings.php        # Site settings
│   └── includes/           # Admin panel template parts
│       ├── footer.php
│       └── header.php
├── assets/                 # Static assets
│   ├── admin/              # Admin assets
│   │   ├── css/
│   │   └── js/
│   └── uploads/            # Uploaded files (images, etc.)
├── config/                 # Configuration files
│   ├── db.php              # Database connection
│   └── function.php        # Global functions
├── theme/                  # Front-end theme
│   └── adrient/            # Current theme
│       ├── 404.php         # Error page
│       ├── about.php       # About page
│       ├── blog-details.php # Single blog post
│       ├── blog.php        # Blog listing
│       ├── contact.php     # Contact page
│       ├── home.php        # Homepage
│       ├── portfolio.php   # Portfolio page
│       ├── service-details.php # Single service
│       ├── services.php    # Services listing
│       └── includes/       # Theme template parts
│           ├── footer.php
│           ├── header.php
│           └── menu.php
├── vendor/                 # Third-party libraries
│   └── phpmailer/          # PHPMailer for sending emails
├── app.php                 # Application loader
├── index.php               # Entry point
├── router.php              # URL router
├── routes.php              # Route definitions
└── sansia.sql              # Database schema and sample data
```

## Installation

### Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

### Setup Instructions

1. **Clone or download the repository** to your web server's document root or a subdirectory.

2. **Create the database:**

   - Create a MySQL database named `sansia`
   - Import the database schema from `sansia.sql` file

3. **Configure the database connection:**

   - Open `config/db.php`
   - Update the following values with your database credentials:

     ```php
     $host = 'localhost';         // Your database host
     $dbname = 'sansia';          // Your database name
     $db_username = 'root';       // Your database username
     $db_password = '';           // Your database password

     // Important: Change the encryption key for security
     define('AES_KEY', 'YOUR_SECURE_KEY_HERE');  // Replace with a strong random string
     ```

4. **Set proper permissions:**

   - Ensure the `assets/uploads` directory is writable by the web server

5. **Security measures:**

   - **IMPORTANT**: Remove or restrict access to `admin/register.php` after creating the initial admin account
   - Make sure to change the default AES encryption key in `config/db.php`

6. **Access the website:**
   - Frontend: `http://your-domain.com/`
   - Admin panel: `http://your-domain.com/admin/`

## Initial Login

After importing the database, you can log in to the admin panel with the following credentials:

- Username: `admin`
- Password: `admin123`

**Important:** Change these credentials immediately after your first login!

## Security Considerations

1. **Change the AES encryption key:**

   - The AES encryption key in `config/db.php` is used for password encryption
   - Replace the default value with a strong random string
   - Example of generating a secure key:
     ```php
     $secure_key = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal string
     ```

2. **Remove or protect the registration page:**

   - After creating necessary admin accounts, either:
     - Delete `admin/register.php`
     - Modify it to restrict access to existing administrators only
     - Add IP restrictions through .htaccess

3. **Secure uploads directory:**

   - Consider adding protection to the `assets/uploads` directory to prevent direct access to sensitive files

4. **Regular backups:**
   - Implement regular database and file backups

## Customization

### General Settings

Access `admin/settings.php` to customize:

- Site name and tagline
- Contact information
- Logo and favicon
- SEO settings for each page
- Social media links
- Email configuration

### Theme Customization

The front-end theme files are located in the `theme/adrient` directory. Modify these files to customize the appearance of your website.

## Credits

- Bootstrap 5
- PHPMailer
- SweetAlert2

## License

This project is licensed under the MIT License - see the LICENSE file for details.
