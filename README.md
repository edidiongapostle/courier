# courier

A shipping web application built with Laravel.

## Requirements

- PHP 8.1 or newer
- Composer
- Node.js (16+) and npm
- MySQL, MariaDB, or another database supported by Laravel

## Quick Start

1. Clone the repository:

	git clone https://github.com/edidiongapostle/courier.git
	cd courier

2. Install PHP dependencies:

	composer install

3. Install JavaScript dependencies and build assets (development):

	npm install
	npm run dev

4. Copy the environment file and set values:

	copy .env.example .env
	php artisan key:generate

	Update `.env` with your database and mail settings.

5. Run database migrations and seeders:

	php artisan migrate --seed

6. Start the local development server:

	php artisan serve

7. Run tests:

	php artisan test

## Deployment notes

- Build production assets with `npm run build`.
- Ensure `APP_ENV` and `APP_DEBUG` are set appropriately in `.env`.
- Do not commit sensitive files like `.env` (already in `.gitignore`).

## Contributing

Contributions are welcome — open an issue or submit a pull request.

## License

See the repository license or add one if needed.
