# World UI

The documentation and component showcase for [`nnjeim/world`](https://github.com/nnjeim/world), published at [world.bmbc.cloud](https://world.bmbc.cloud).

The landing page introduces the package, exercises its live API, and provides copy-ready country selector examples for Blade, React, Angular, and Vue.

## Stack

- PHP 8.4
- Laravel 13
- Tailwind CSS 4 and Vite 8
- `nnjeim/world` 1.1.39

## Local development

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan world:install
composer run dev
```

The application requires PHP 8.4 or later. The default environment uses SQLite and exposes the package routes under `/api`.

## Verification

```bash
php artisan test --compact
vendor/bin/pint --dirty
npm run build
```

## Container

The multi-stage image compiles frontend assets with Node 22, installs production Composer dependencies, seeds the World SQLite database, and serves Laravel with PHP 8.4 and Apache.

```bash
docker build -t world-ui .
```

Kubernetes manifests live in the adjacent `home-k8s/world-ui` directory. Production images are published to `harbor.bmbc.cloud/library/world-ui`.
