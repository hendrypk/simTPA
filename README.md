# simTPA

This project is a Laravel-based application with authentication and email functionality (using Mailtrap for email testing).

## Prerequisites

- PHP >= 8.2
- Composer
- npm
- Laravel 11

## Installation

### 1. Clone the repository

Clone this project to your local machine using Git:

```bash
git clone https://github.com/hendrypk/simTPA.git

### 2. Install PHP Dependencies
Navigate to the project directory and run the following command to install PHP dependencies using:

```bash
composer install

### 3. Install Frontend Dependencies
install the required npm packages, then run the following command to build the frontend assets:

```bash
npm install

```bash
npm run build

### 4. Install Laravel Media Library
Media Library can be installed via Composer:

```bash
composer require "spatie/laravel-medialibrary"


```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

### 5. Install Laravel Permission
```bash
composer require spatie/laravel-permission

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

### 6. Set Up The Environment
Copy the .env.example file to .env, then generate the application key:

```bash
cp .env.example .env


```bash
php artisan key:generate


### 7. Set Up The Database
Run the migration and seed the database:

```bash
php artisan migrate --seed


### 8. Configure Mailtrap for Email Functionality
For email reset password functionality, you need to set up Mailtrap in your .env file. Follow the steps below:

- Create a Mailtrap account at Mailtrap.
- Create a new inbox in Mailtrap and copy the SMTP settings.
- In the .env file, add or update the following configuration:

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

### 9. Demo Log In
Use the following credentials to log in to the application:
Email: hendryputra934@gmail.com
Password: superadmin
