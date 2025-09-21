<p><img src="public/logo.svg" width="600" alt="Laravel React Logo"></p>

<p>
<a href="https://github.com/cvtmal/laravel-react-starter/actions"><img src="https://github.com/cvtmal/laravel-react-starter/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.com/cvtmal/laravel-react-starter"><img src="https://img.shields.io/badge/license-MIT-green" alt="License"></a>
<a href="https://herd.laravel.com/new?starter-kit=cvtmal/laravel-react-starter"><img src="https://img.shields.io/badge/Install%20with%20Herd-f55247?logo=laravel&logoColor=white" alt="Install with Laravel Herd"></a>
<a href="https://github.com/nunomaduro/essentials"><img src="https://img.shields.io/badge/Powered%20by-Essentials-blue?logo=laravel&logoColor=white" alt="Powered by Essentials"></a>
</p>

# cvtmal/laravel-react-starter
A Nuno Maduro-inspired Laravel + React starter kit, powered by [Essentials](https://github.com/nunomaduro/essentials) for strict defaults and modern tooling. Features **Inertia 2** for seamless React integration and **Laravel Wayfinder** for type-safe routing. Jumpstart your full-stack SPAs with robust QA, opinionated structure, and cutting-edge Laravel + React tooling.

## Inspired By
This starter kit draws heavy inspiration from Nuno Maduro's [Essentials](https://github.com/nunomaduro/essentials) package—which enforces strict models, auto-eager loading, and immutable dates—and his [Laravel Starter Kit](https://github.com/nunomaduro/laravel-starter-kit), a blueprint for meticulous Laravel projects. We've extended these with **Inertia 2** and **React** integration via Vite, plus **Laravel Wayfinder** for type-safe routing, making it ideal for modern full-stack SPAs while preserving Nuno's emphasis on code quality and architectural precision.

## Requirements
- **PHP Version:** 8.4+
- **Laravel Version:** 12.x
- **Node.js:** 18+ (for React/Vite)
- **Composer Dependencies:** Requires `nunomaduro/essentials`, `inertiajs/inertia-laravel`, and `laravel/wayfinder`

## Features
### React Integration
- **Inertia 2 + React:** Latest Inertia.js v2 for seamless Laravel-React integration without API complexity
- **Laravel Wayfinder:** Type-safe route helpers for React components with full TypeScript support
- **Vite-powered setup** with hot reloading for lightning-fast development
- **SSR support** with `composer dev:ssr` for server-side rendering capabilities
- **Optimized build process** tailored for modern Laravel + React full-stack applications

### Static Analysis & QA
- **Essentials-Powered Defaults:** Strict models (blocks lazy loading and missing attributes), auto-eager loading for N+1 prevention, immutable dates with CarbonImmutable, and production-safe Artisan commands—straight from Nuno's Essentials
- **Larastan/PHPStan:** Configured with `phpstan.neon` set to maximum level (10). Note that framework-specific react starter kit code is annotated with `// @phpstan-ignore-line` to bypass false positives
- **Rector PHP:** Automated refactoring and code modernization
- **Laravel Pint:** Strict rules defined in `pint.json` for consistent code style

### Project Structure
Mirrors the opinionated structure from Nuno's Laravel Starter Kit for clean, testable code:
- **Actions:** Single-purpose business logic classes independent of HTTP concerns in `app/Actions`
- **Enums:** Place your enumerations in `app/Enums`
- **Services:** Service classes get located in `app/Services`

### Testing
Aims for 100% coverage, aligned with Nuno's strict testing ethos:

#### Unit Tests:
- Actions tests are in `tests/Unit/Actions`
- Enums tests are in `tests/Unit/Enums`
- Models tests are in `tests/Unit/Models`

#### Architecture Tests:
- Adding `tests/Unit/ArchTest.php`
- Included to ensure the project adheres to established architectural guidelines

### Quick Start
1. Clone and `composer install`
2. `cp .env.example .env` and generate key with `php artisan key:generate`
3. `npm install` to install React dependencies
4. `composer dev` - Runs Laravel server, queue worker, logs, and Vite dev server concurrently
5. Alternative: `composer dev:ssr` - Same as above but with Inertia SSR enabled
6. `composer lint` - Run Pint, Rector, and npm linting for code cleanup
7. `composer test` - Full test suite with type coverage, unit tests, linting, and PHPStan

### Custom Configurations
- **AppServiceProvider:** Configured with custom rules to further align with your project requirements.
- **PHPStan:** Custom settings in `phpstan.neon` to suit your project's needs.
- **Rector PHP:** Configured in `rector.php` for automated refactoring.
- **Laravel Pint:** Configured in `pint.json` for code style enforcement.
- **Environment File:** Example environment file provided as `.env.example`.
- **GitHub Actions:** CI/CD pipeline configured in `.github/workflows/tests.yml` for automated testing and quality checks.

## Project Structure
```plaintext
├── app
│   ├── Actions/                         # Actions Pattern
│   ├── Enums/                           # Enums
│   ├── Providers
│       └── AppServiceProvider.php       # Customized App Service Provider
│   └── Services/                        # Service classes
├── resources
│   └── js                               # React app (Inertia 2 + Vite)
│       ├── Components/
│       ├── Pages/                       # Inertia page components
│       ├── app.tsx                      # Inertia app entry point
│       └── ssr.tsx                      # SSR entry point
├── tests
│   └── Unit
│       ├── Actions/                     # Unit tests for actions
│       ├── Enums/                       # Unit tests for enums
│       ├── Models/                      # Unit tests for models
│       └── ArchTest.php                 # Architecture tests
├── .env.example                         # Example environment file
├── phpstan.neon                         # PHPStan configuration
├── pint.json                            # Laravel Pint configuration
└── rector.php                           # Rector PHP configuration
```

## Customization
- **Essentials:** Publish config with `php artisan vendor:publish --tag=essentials-config` to tweak strict defaults and auto-eager loading behavior
- **Inertia:** Configure middleware, SSR settings, and shared data in `app/Http/Middleware/HandleInertiaRequests.php`
- **Wayfinder:** Generate type-safe routes with `php artisan wayfinder:generate` for React components
- **PHPStan & Larastan:** Refer to `phpstan.neon` for custom settings and the use of `// @phpstan-ignore-line` in framework-specific code
- **Rector PHP:** Adjust the configuration as needed to tailor refactoring rules
- **Laravel Pint:** Modify `pint.json` to enforce or relax specific style guidelines
- **AppServiceProvider:** Check the custom rules applied within the `App\Providers\AppServiceProvider` for application-wide configurations

## Contributing
Contributions are welcome! Feel free to fork this repository, make improvements, and submit pull requests. Please ensure that your changes adhere to the project's coding standards and pass all tests. Star/fork if you love Nuno's approach—let's make React + Laravel even stricter!

## License
This project is open-source and available under the [MIT License](LICENSE).
