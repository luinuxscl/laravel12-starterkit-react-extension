# Laravel 12 React Starter Kit Extension

Extensión del Starter Kit oficial con React 19 + TypeScript + Inertia 2, Tailwind 4, shadcn/ui.

## Requisitos
- PHP 8.3.x (recomendado 8.3.6)
- Node 20+ (CI usa 22)
- Composer 2

## Setup Rápido
```bash
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database && touch database/database.sqlite
php artisan migrate --graceful
npm ci
npm run dev # o npm run build
```

## Ejecutar Tests (Pest v4)
```bash
./vendor/bin/pest
```

## Scripts útiles
- `npm run dev`: Vite en modo desarrollo
- `npm run build`: Build de assets
- `npm run format`: Formateo con Prettier (resources/)
- `npm run lint`: ESLint (JS/TS/React)
- `composer test`: Limpia config cache y ejecuta tests

## CI/CD (GitHub Actions)
- `.github/workflows/tests.yml`
  - PHP 8.3, Node 22
  - Base de datos SQLite en CI (`DB_CONNECTION=sqlite`)
  - Migra antes de correr Pest
- `.github/workflows/lint.yml`
  - PHP 8.3
  - `npm ci` para instalaciones determinísticas
  - Laravel Pint + Prettier + ESLint

## Convenciones
- Commits: Conventional Commits
- Estilo PHP: PSR-12 (Laravel Pint)
- TS estricto, sin `any` no tipado

## Roadmap
Ver `ROADMAP.md`. Trabajo por fases (F1–F6). Issues vinculadas en GitHub.
