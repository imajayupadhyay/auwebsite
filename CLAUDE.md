# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

Laravel 12 (PHP 8.2+) backend serving a Vue 3 SPA via **Inertia.js**. Styling is **Tailwind CSS v4** (config-in-CSS via `@theme` in `resources/css/app.css`). Build tool is Vite 7. Default DB is SQLite at `database/database.sqlite`.

This is a personal marketing/portfolio site ("Ajay Upadhyay — DevOps Instructor & Cloud Architect"). At present there is a single `GET /` route rendering `Home/Index`, a single `User` model (default Laravel), and no custom controllers.

## Commands

```bash
# One-shot bootstrap (install + key + migrate + npm build)
composer run setup

# Full dev stack — runs php serve, queue:listen, pail (log tail), and vite concurrently
composer run dev

# Backend only / frontend only
php artisan serve
npm run dev
npm run build

# Tests — clears config first, then runs PHPUnit suites (Unit + Feature)
composer run test
php artisan test --filter=TestName       # single test
./vendor/bin/phpunit --filter=TestName   # alternative runner

# Code style (Laravel Pint is installed as a dev dep)
./vendor/bin/pint
./vendor/bin/pint --test                 # check without writing

# Migrations
php artisan migrate
php artisan migrate:fresh --seed
```

Tests run against an in-memory SQLite (`DB_DATABASE=:memory:`) — see `phpunit.xml`. Queue, cache, and session drivers are all overridden to `array`/`sync`/`null` during tests, so tests do not touch the real SQLite file.

## Architecture notes

**Inertia is the routing/view layer.** Routes in `routes/web.php` return `Inertia::render('Page/Name')` — there is no Blade view layer beyond the root template `resources/views/app.blade.php`, which is the only server-rendered HTML and is the value of `HandleInertiaRequests::$rootView = 'app'`. Every request goes through `HandleInertiaRequests` (registered in `bootstrap/app.php` via `$middleware->web(append: …)`). Shared props for all pages go in that middleware's `share()` method.

**Vue page resolution** (`resources/js/app.js`) uses `resolvePageComponent` against `./Pages/**/*.vue`, so the string passed to `Inertia::render` maps directly to a file under `resources/js/Pages/`. Page-local subcomponents live in a sibling `components/` folder (e.g. `Pages/Home/components/Hero.vue`); globally reusable components live under `resources/js/Components/Global/`. The `@` alias resolves to `resources/js` (see `vite.config.js`).

**Root template dual-loading:** `app.blade.php` calls `@vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])` — it preloads the specific page component for the current request in addition to the app entry, so new pages are picked up automatically as long as they live under `resources/js/Pages/` with a matching path.

**Tailwind v4 is configured in CSS, not JS.** There is no `tailwind.config.js`. Design tokens (fonts `Bricolage Grotesque` / `Manrope` / `JetBrains Mono`, custom `ink-*` dark palette, `cyan-glow`/`teal-glow`/`amber-spark` accents) are declared under `@theme` in `resources/css/app.css`. Content sources are declared with `@source` directives in the same file (`.blade.php`, `.vue`, `.js`). Custom utilities (`.glass`, `.glass-strong`, `.text-gradient-cyan`, `.noise`) are defined in `@layer utilities` there as well — prefer extending that file over adding one-off inline styles when a visual pattern repeats.

**Laravel 12 bootstrap style.** Configuration lives in `bootstrap/app.php` using the `Application::configure()` fluent API (no `Kernel.php`, no `app/Http/Kernel.php`). Service providers are registered in `bootstrap/providers.php`. Add middleware, exception handlers, and routing via the closures in `bootstrap/app.php`.

**Defaults worth knowing before adding features:**
- Queue, cache, and sessions all default to the `database` driver — any new queue/cache/session work requires running migrations, not adding Redis.
- `QUEUE_CONNECTION=database` means `composer run dev` is actively running `queue:listen`; dispatched jobs will execute in that terminal.
- Broadcasting defaults to `log` — events won't go anywhere real without reconfiguration.
