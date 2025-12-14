# Loc-Vehicule

A Laravel application for vehicle rental management.

## About

This repository is a Laravel 12 project (PHP ^8.2) with Filament 4 and Spatie permissions. The app includes models, factories, migrations and seeders to manage brands, vehicles, clients and rental contracts.

## Installation

Follow these steps to get the project running locally.

1. Prerequisites

   - PHP ^8.2
   - Composer
   - A database server (MySQL, PostgreSQL, or SQLite)
   - Node.js and npm (for frontend assets)

2. Clone the repository

```bash
git clone https://github.com/Prince-Gon/loc-vehicule.git
cd loc-vehicule
```

3. Install PHP dependencies

```bash
composer install
```

4. Create environment file and generate app key

```bash
copy .env.example .env    # Windows
# or on Unix-like systems:
cp .env.example .env
php artisan key:generate
```

5. Configure the database

Edit the `.env` file and set your DB variables, for example:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

For SQLite create the file and set:

```ini
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

6. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

7. Install frontend dependencies and build assets

```bash
npm install
npm run dev   # or `npm run build` for production
```

8. Start the development server

```bash
composer run dev
```

Open http://127.0.0.1:8000 in your browser.