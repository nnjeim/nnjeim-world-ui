# World UI

The documentation and interactive component showcase for [`nnjeim/world`](https://github.com/nnjeim/world), published at [world.bmbc.cloud](https://world.bmbc.cloud).

The site introduces the package, exercises its live API, and provides copy-ready Blade, React, Angular, and Vue examples. The component catalogue currently covers country, dependent country/state/city, currency, language, and timezone selectors.

## Stack

- PHP 8.4
- Laravel 13
- Tailwind CSS 4 and Vite 8
- `nnjeim/world` 2.0.0 (tested commit preview until the release is published)

## Local development

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php -d memory_limit=1G artisan world:install
composer run dev
```

The application requires PHP 8.4 or later. The default environment uses SQLite and exposes the package routes under `/api`.

## Package version and upgrades

The site exercises World 2.0. The landing page and component guides link both the
[2.0 documentation](https://github.com/nnjeim/world/blob/master/docs/2.0/README.md) and
[1.x documentation](https://github.com/nnjeim/world/blob/master/docs/1.x/README.md).
Existing users should review the [upgrade guide](https://github.com/nnjeim/world/blob/master/docs/2.0/UPGRADE.md).
Caret 1.x constraints stay on 1.x. The demo selects database IDs from API responses;
example IDs are not portable between installations.

## Component catalogue

The catalogue is available under `/components` and redirects to the country selector. Each page includes a live API-backed preview, implementation snippets for all four supported UI stacks, an API reference, component contract, validation guidance, and accessibility notes.

| Page | Route |
| --- | --- |
| Country selector | `/components/country-selector` |
| Country, state, and city selector | `/components/location-selector` |
| Currency selector | `/components/currency-selector` |
| Language selector | `/components/language-selector` |
| Timezone selector | `/components/timezone-selector` |

## Verification

```bash
php artisan test --compact
vendor/bin/pint --dirty
npm run build
npx playwright install chromium
npm run test:browser
```

Playwright starts Laravel automatically for local runs. To exercise an already-running build, set `PLAYWRIGHT_BASE_URL`, for example:

```bash
PLAYWRIGHT_BASE_URL=http://127.0.0.1:8099 npm run test:browser
```

## Container

The multi-stage image compiles frontend assets with Node 22, installs production Composer dependencies, seeds the World SQLite database, and serves Laravel with PHP 8.4 and Apache. Its standalone defaults use filesystem cache and sessions; Kubernetes overrides the cache with the shared `redis-standalone` service on an isolated World UI prefix and database.

```bash
docker build -t world-ui .
```

Kubernetes manifests live in the adjacent `home-k8s/world-ui` directory. Production images are published to `harbor.bmbc.cloud/library/world-ui`.

## Delivery and monitoring

- `CI` runs formatting, Laravel feature tests, the production frontend build, and Playwright in desktop and mobile Chromium on pull requests and `main`.
- `Release` is a manual workflow that builds an AMD64 image tagged with the application commit and `latest`. With its `deploy` input enabled, it rolls out that immutable tag and opens the corresponding `nnjeim/bmbc-cluster` manifest pull request.
- `Production smoke check` checks the public landing page and the 250-country API response every 30 minutes and can also be run manually.
- Dependabot checks Composer, npm, and GitHub Actions dependencies monthly.

The release workflow requires the following production configuration:

| Name | Purpose |
| --- | --- |
| `HARBOR_USERNAME` | Harbor registry login |
| `HARBOR_PASSWORD` | Harbor registry password |
| `CLUSTER_REPO_TOKEN` | Push a manifest branch and open its pull request |

The deploy job uses the `world-ui-deploy` runner in the World namespace, with `kubectl`, `curl`, `jq`, Git, and GitHub CLI installed. It authenticates to Kubernetes through its service account, whose permissions are limited to the World UI deployment and rollout observation. Runner manifests live in `home-k8s/world-ui`. No production credentials are stored in this repository.
