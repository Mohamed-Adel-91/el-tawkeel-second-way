# El-Tawkeel documentation & manual guide

[![Laravel Logo](public/logo2.png)](https://github.com/ElTawkeel/ElTawkeel)

## Overview

El-Tawkeel is a Laravel-based corporate website. The application exposes a public-facing site and an admin dashboard for managing pages, services, brands, news, vacancies and more.

## Directory Structure

The `app/` directory contains most of the project code:

- **Console** – custom artisan commands and the scheduler.
- **Enums** – enumerations used across models.
- **Exports** – classes for generating Excel downloads.
- **Helpers** – helper classes and global functions.
- **Http** – controllers, middleware and form requests.
  - `Controllers/Admin` – admin dashboard logic.
  - `Controllers/Api` – API controllers.
  - `Controllers/Web` – frontend controllers.
- **Models** – Eloquent models representing database tables.
- **Providers** – service providers including a custom translation loader.
- **Services** – reusable services such as the DB translation loader.
- **Traits** – shared functionality like API responses and file uploads.
- **Rules** – custom validation rules.

## Installation

To set up the project locally you will need PHP and Node.js installed. Start by
installing the PHP dependencies using Composer which reads the `composer.lock`
file to install the exact versions required:

```bash
composer install
```

Copy the example environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Finally run the migrations and create a symbolic link for storage:

```bash
php artisan migrate
php artisan storage:link
```

## Testing

The test suite relies on an in-memory SQLite database. Ensure that the `pdo_sqlite` and `sqlite3` extensions are enabled in your `php.ini` file.

Example:

- **Windows** – remove the leading semicolons from the `extension=pdo_sqlite` and `extension=sqlite3` lines in `php.ini`.
- **Linux** – install the SQLite extension package (e.g., `sudo apt-get install php-sqlite3`) and verify both entries are enabled.

Run the tests with:

```bash
php artisan test
```

## Admin Dashboard

This project ships with an administration panel used to manage the website. Log
in at `/login` with your admin credentials and you will be redirected to
`/dashboard`. The sidebar in the dashboard provides quick links to all
management sections.

## Admin Routes

The admin dashboard exposes resourceful routes for most modules. Below is a high level overview of the controllers found in `app/Http/Controllers/Admin`:

## Artisan Commands

Custom commands live in `app/Console/Commands`. The project currently ships with:

- `offers:deactivate-expired` – disables expired offers. It is scheduled to run every six hours via the task scheduler.

Run all commands with `php artisan <command>`.

## Environment Configuration

Copy `.env.example` to `.env` and adjust your settings. Common variables include database credentials (`DB_*`), mail server details (`MAIL_*`), activity log flags (`ACTIVITY_LOGGER_*`), and custom keys like `PRM_AUTH_TOKEN_KEY` and `SITE_URL`.

## Migrations & Seeding

Run migrations using `php artisan migrate`. Seeders in `database/seeders` populate reference data and can be executed with `php artisan db:seed`. You can run both steps together with `php artisan migrate --seed`.

## Deployment

Typical deployment steps are:

1. `composer install --no-dev`
2. `npm install && npm run build`
3. Configure the `.env` file and run `php artisan key:generate`.
4. `php artisan migrate --force`
5. `php artisan storage:link`
6. Set up a cron job to run `php artisan schedule:run` every minute.

[![Laravel Logo](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)](https://laravel.com)

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/framework)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## _Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
