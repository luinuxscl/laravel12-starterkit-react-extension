# Laravel 12 React Starter Kit Extension

Extensión enterprise-ready del Laravel 12 React Starter Kit oficial.

- Backend: Laravel 12 (PHP 8.3)
- Frontend: React 19 + TypeScript + Inertia v2
- UI: Tailwind 4 + shadcn/ui
- Testing: Pest v4 (backend), Vitest (frontend)

## Requisitos
- PHP 8.3, Composer
- Node 22, npm 10

## Setup rápido
```bash
cp .env.example .env
php artisan key:generate

# Instalar dependencias
composer install
npm ci

# Compilar assets
npm run build
```

## Base de datos (dev)
- SQLite por defecto. Asegúrate de tener el archivo `database/database.sqlite` creado:
```bash
touch database/database.sqlite
```

## Comando de instalación
Comando maestro para preparar la app. Soporta modo desarrollo para datos de ejemplo.

```bash
# Instalación base (migraciones + roles base)
php artisan app:install

# Instalación para desarrollo (además crea usuarios demo con roles)
php artisan app:install --dev
```

Usuarios demo creados con `--dev` (password: `password`, solo dev):
- root@demo.com → rol root
- admin@demo.com → rol admin
- standard@demo.com → rol standard

## Testing (backend)
```bash
php artisan migrate --graceful
./vendor/bin/pest
```

## CI (GitHub Actions)
Workflows en `/.github/workflows/`:
- tests.yml: instala deps, migra SQLite y corre Pest
- lint.yml: Pint, ESLint y Prettier

## Ramas y PRs
- Feature branches desde `develop`.
- CI corre en los PRs. Merge sólo con checks en verde.

## Scripts npm útiles
```bash
npm run dev
npm run build
npm run lint
npm run format
```
