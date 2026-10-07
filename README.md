# Nexus Qart

A Laravel 12 company portfolio with a dedicated showcase for **Nexa**, the separate QR menu application at [getwooperly.com/login](https://getwooperly.com/login).

## Run locally

Requires PHP 8.2+, Composer 2, and Laravel's PHP extensions. No database, frontend build, queue worker, or Node.js runtime is needed to serve the site.

```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

On PowerShell, use `Copy-Item .env.example .env` instead of `cp`. Open [localhost:8000](http://localhost:8000). Copy the environment file only on first setup; preserve existing keys and settings.

## Pages and editing

- `routes/web.php`: Home, About, Services, Products, Nexa, and Contact routes.
- `resources/views/pages/`: page content.
- `resources/views/components/`: shared layout, navigation, footer, product screenshots, and calls to action.
- `public/assets/site.css` and `site.js`: responsive styling and accessible mobile navigation.
- `public/assets/nexus-qart-logo.svg`: supplied wordmark for light backgrounds; `nexus-qart-logo-light.svg`: footer variant; `nexus-qart-logo-mono.svg`: monochrome variant; `nexus-qart-mark.svg`: standalone mark and favicon. These production copies have the SVG path fill corrected and are independent of the source files in the project root.
- `config/portfolio.php`: environment-backed contact email and Nexa link.

The original static index and unavailable build scripts have been replaced by Laravel. Old company, pricing, and Intelligent QR routes redirect to their corresponding new pages.

## Content and configuration

### Adding a product

The Products page and footer read from `config/products.php`. Add an entry with `name`, `category`, `tagline`, `description`, and either a named `route` (with its page defined in `routes/web.php`) or an external `url`. Optional fields are `login_url` and `image` (a path relative to `public/`). Without artwork, the listing displays the company mark. Nexa currently uses a custom `preview`. Rebuild production configuration caches after changing the catalog. The homepage can continue to feature one selected product independently of the full catalog.

Set `APP_URL` to the final HTTPS origin for correct generated URLs. Set `CONTACT_EMAIL` to the company inbox; the default is `hello@nexusqart.com`. `WOOPERLY_URL` defaults to the supplied login URL.

Contact links open an email draft; the website does not send or store enquiries. Nexa keeps its own login and account handling. The menu and AI assistant screenshots are supplied product captures; the depicted business branding and menu content are examples. Features, pricing and offers follow the supplied Nexa Product Overview v2 (October 2026). Cart/ordering, semantic search and AI improvements are labeled as planned. Company/service copy is an initial draft for review. No invented client list or testimonials are included.

## Verification

```sh
composer test
composer lint
php artisan view:cache
composer validate --strict
```

Optional browser checks require Node.js and installed Microsoft Edge:

```sh
npm ci
npm run check
npm run test:browser
```

Tests start their own server on port 4174, check all six pages at 1440, 768, 390, and 320 pixels, and save screenshots under ignored `.qa/`. Set `BROWSER_CHANNEL=chrome` to use installed Chrome instead. Tests check navigation, local links, images, email drafts, FAQs, keyboard access, and navigation without JavaScript. They do not log in to Nexa or send email.

## Namecheap deployment

See [deploy/NAMECHEAP.md](deploy/NAMECHEAP.md) for both configurable document roots and fixed `public_html` hosting. Upload the PHP application and its production dependencies; npm and Node.js are only used for development checks.
