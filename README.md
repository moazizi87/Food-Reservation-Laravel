# Food Reservation System (Laravel)

A full-featured food reservation and ordering platform built with Laravel. This system supports role-based access for Admins and Students, complete CRUD for foods and categories, order management, user profiles, and more.

---

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Default Accounts](#default-accounts)
- [Usage Guide](#usage-guide)
- [Project Structure](#project-structure)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## Features
- **Role-based access:** Admin and Student roles with different permissions
- **CRUD for Foods & Categories:** Add, edit, delete, and list foods and categories
- **Order Management:** Students can place and cancel orders; Admins can manage all orders
- **Order History:** Students can view their order history
- **Profile Management:** Users can update their profile and delete their account
- **Image Uploads:** Upload and display images for foods and categories
- **Modern UI:** Bootstrap-based, responsive, and user-friendly

---

## Requirements
- PHP >= 8.1
- Composer
- MySQL or compatible database
- Node.js & npm (for asset compilation, optional)
- Laravel 10/11/12 (tested on 12)

---

## Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url> Food-Reservation-Laravel
   cd Food-Reservation-Laravel
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
   Or if you have only `composer.phar`:
   ```bash
   php composer.phar install
   ```

3. **Install Node dependencies (optional, for assets):**
   ```bash
   npm install && npm run build
   ```

---

## Configuration

1. **Copy the example environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Set your database credentials** in `.env`:
   ```env
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

3. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

---

## Database Setup

1. **Run migrations and seeders:**
   This will create all tables and seed the database with sample data (including an admin account).
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Create the storage symlink (for image uploads):**
   ```bash
   php artisan storage:link
   ```

---

## Running the Application

Start the Laravel development server:
```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Default Accounts

After seeding, you can log in as:

**Admin:**
- Email: `admin@example.com`
- Password: `password`

**Student:**
- Email: `student1@example.com`
- Password: `password`

(You can register new students via the registration form.)

---

## Usage Guide

### Admin Features
- **Dashboard:** Overview and quick links
- **Manage Foods:** Add, edit, delete, and list all foods
- **Manage Categories:** Add, edit, delete, and list all categories
- **Manage Orders:** View all orders, update their status, and delete orders

### Student Features
- **View Menu:** Browse available foods and place orders
- **Order History:** View and cancel your own orders (if still pending)
- **Profile:** Update your name/email or delete your account

### Image Uploads
- When adding or editing foods/categories, you can upload an image. Uploaded images are stored in `storage/app/public` and served via `public/storage`.

---

## Project Structure

- `app/Models/` — Eloquent models (User, Student, Food, Category, Order, OrderItem)
- `app/Http/Controllers/` — Controllers for all features
- `app/Policies/` — Authorization policies
- `app/Http/Middleware/` — Custom middleware (e.g., role checking)
- `resources/views/` — Blade templates (Bootstrap-based)
- `routes/web.php` — All web routes
- `database/migrations/` — Database schema
- `database/seeders/` — Seeders for initial data

---

## Troubleshooting

- **Images not displaying after upload:**
  - Make sure you have run `php artisan storage:link`.
  - Check that your web server has write permissions to `storage/` and `public/storage/`.

- **Class or view component errors:**
  - All views use standard Blade and Bootstrap. If you see errors like `Unable to locate a class or view for component [...]`, make sure you are not using Jetstream/Breeze components in your custom views.

- **403 Forbidden when canceling orders as student:**
  - Ensure the `destroy` route for orders is available to students in `routes/web.php`.

- **Database errors (table not found, etc):**
  - Make sure you have run all migrations and seeders.

- **Other issues:**
  - Clear all caches:
    ```bash
    php artisan optimize:clear
    ```

---

## License

This project is provided for educational and demonstration purposes. For production use, please review and adapt security, validation, and deployment settings as needed. 