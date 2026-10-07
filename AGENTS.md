# Repository Guidelines

## Project Structure & Module Organization

Nexus Qart is a Laravel 12 company portfolio targeting PHP 8.2. Routes live in `routes/web.php`; page templates are in `resources/views/pages/`, with shared Blade components in `resources/views/components/`. Public CSS, JavaScript, and SVG branding live in `public/assets/`. Configuration is in `config/`; environment-specific values belong in `.env`.

Nexa remains a separate QR menu application linked through `config/portfolio.php`; its current login stays at getwooperly.com. Do not implement local login or duplicate its backend. The portfolio uses file sessions/cache and requires no database.

## Build, Test, and Development Commands

- `composer install`: install locked PHP dependencies.
- Copy `.env.example` to `.env` on first setup, then run `php artisan key:generate`.
- `php artisan serve`: preview locally.
- `composer test`: run PHPUnit feature tests.
- `composer lint`: check PHP formatting with Laravel Pint.
- `php artisan view:cache`: verify Blade compilation.
- `npm ci && npm run test:browser`: run optional Playwright checks with installed Edge.
- `npm run check`: verify JavaScript syntax.

No frontend build or Node.js runtime is required in production.

## Coding Style & Naming Conventions

Follow Laravel conventions: four-space PHP indentation, PascalCase classes, and named routes. Use two spaces for Blade, CSS, and JavaScript. Keep components reusable and descriptive; use kebab-case CSS classes and SVG filenames. Read environment variables through configuration files, then use `config()` in templates. Escape dynamic content with Blade's standard double braces.

## Testing Guidelines

Place PHPUnit feature tests in `tests/Feature/*Test.php` and browser checks in `tests/Browser/*.spec.js`. Cover route behavior, external product links, contact URL encoding, and changed interactions. Browser tests exercise 1440, 768, 390, and 320 pixel layouts and save ignored screenshots in `.qa/`. No coverage percentage is mandated.

## Commit & Pull Request Guidelines

The initial history establishes no commit convention. Use concise, imperative subjects. Describe the purpose, validation results, and outstanding limitations in PRs; link relevant issues and include desktop/mobile screenshots for visual changes.

## Deployment & Content

Follow `deploy/NAMECHEAP.md`; expose only public files. Never commit secrets, vendor dependencies, or generated caches. Keep contact details configurable, label illustrative product artwork, and avoid unverified prices, offers, clients, or product capabilities.
