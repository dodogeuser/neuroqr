# Deploy Nexus Qart on Namecheap shared hosting

This project targets Laravel 12 and PHP 8.2; Composer resolves dependencies for PHP 8.2.34. It uses file sessions/cache, with no database, queue worker, scheduled task, or Node.js server.

## 1. Prepare the hosting account

In cPanel, confirm the **website's** PHP version is 8.2 or compatible; the SSH CLI version alone does not establish the web version. Required extensions: Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, and XML. Use Composer 2.

Use a separate domain or subdomain for the company portfolio. Leave the existing Nexa application and its document root intact. Back up any existing files at the portfolio destination before replacing them.

## 2. Upload the application

Place the application outside the publicly served directory, for example:

```text
/home/USERNAME/nexus-qart/
```

Upload `app/`, `bootstrap/`, `config/`, `public/`, `resources/`, `routes/`, `storage/`, `artisan`, `composer.json`, `composer.lock`, and `.env.example`. Include the tracked empty-directory `.gitignore` files so storage directories exist.

Do not upload your local `.env`, `node_modules/`, `.git/`, `.tools/`, `.qa/`, tests, or local generated cache files. In particular, omit generated PHP files inside `bootstrap/cache/` and `storage/framework/views/`.

In SSH:

```sh
cd ~/nexus-qart
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Copy the environment file and generate a key only for the first installation. Preserve the production key on future releases. If Composer is unavailable on the server, install production dependencies in a clean local staging copy and upload its `vendor/` directory too.

## 3. Configure production

Edit the private `.env`:

```dotenv
APP_NAME="Nexus Qart"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-PORTFOLIO-DOMAIN
SESSION_DRIVER=file
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
CONTACT_EMAIL=hello@nexusqart.com
WOOPERLY_URL=https://getwooperly.com/login
```

Replace the domain and email placeholders; retain the generated `APP_KEY`. Enable the domain's SSL certificate and HTTPS redirect in cPanel. Ensure the account's PHP process can write to `storage/` and `bootstrap/cache/`; use owner-appropriate permissions, not blanket 777.

## 4. Choose the public directory arrangement

### A. Configurable document root (preferred)

Point the portfolio domain's document root to:

```text
/home/USERNAME/nexus-qart/public
```

Keep the supplied `public/index.php` and `public/.htaccess`. Do not point the document root at the application root.

### B. Fixed primary-domain public_html

For a portfolio domain fixed to `/home/USERNAME/public_html`:

1. Keep the application in `/home/USERNAME/nexus-qart`.
2. Copy only the **contents** of its `public/` folder, including hidden `.htaccess`, into `public_html/`.
3. Replace the copied `public_html/index.php` with this repository's `deploy/public_html/index.php`. Its `$basePath` assumes the sibling folder is named `nexus-qart`; adjust it if you chose another path.
4. Remove or back up an old `public_html/index.html` if it overrides PHP. Preserve cPanel-generated PHP handler directives when updating `.htaccess`.

For this arrangement, copy updated public assets into `public_html/assets/` on subsequent deployments as well. Do not place `.env`, `vendor/`, or the complete application in `public_html`. If this root currently serves Nexa, use a separate portfolio domain/subdomain instead.

## 5. Finish and verify

From `~/nexus-qart`:

```sh
php artisan optimize:clear
composer check-platform-reqs --no-dev
php artisan optimize
```

Visit all six routes: `/`, `/about`, `/services`, `/products`, `/products/nexa`, and `/contact`. Verify assets, mobile navigation, the email address, and the Nexa login link. `/up` should return HTTP 200.

Confirm `/.env`, `/composer.json`, and `/storage/logs/laravel.log` are inaccessible. If inner pages return 404, check that `.htaccess` was uploaded and Apache rewriting is enabled. For a 500 error, inspect the private `storage/logs/laravel.log`, PHP version/extensions, and writable directories; keep production debug disabled.

After changing environment settings or templates, clear and rebuild caches. This repository has not been deployed to your hosting account.

## References

- [Laravel 12 deployment requirements and public directory](https://laravel.com/docs/12.x/deployment)
- [Namecheap Laravel hosting instructions](https://www.namecheap.com/support/knowledgebase/article.aspx/9694/29/how-to-install-laravel-on-our-server/) — use this project's PHP 8.2/Laravel 12 requirements rather than the older versions in their example.
- [Namecheap domain document roots](https://www.namecheap.com/support/knowledgebase/article.aspx/10125/29/how-to-manage-domains-in-cpanel/)
