# Laravel 12 React Starter Kit Extension

Extensión del Starter Kit oficial con React 19 + TypeScript + Inertia 2, Tailwind 4 y shadcn/ui, lista para entornos enterprise.

- Backend: Laravel 12 (PHP 8.3)
- Frontend: React 19 + TypeScript + Inertia v2
- UI: Tailwind 4 + shadcn/ui
- Testing: Pest v4 (backend), Vitest (frontend)

## Requisitos
- PHP 8.3.x (recomendado 8.3.6)
- Node 20+ (en CI usamos 22) y npm 10+
- Composer 2

## Setup rápido
```bash
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database && touch database/database.sqlite
php artisan migrate --graceful
npm ci
npm run dev # o npm run build
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
./vendor/bin/pest
```

## Scripts útiles
- `npm run dev`: Vite en modo desarrollo
- `npm run build`: Build de assets
- `npm run format`: Formateo con Prettier (resources/)
- `npm run lint`: ESLint (JS/TS/React)
- `composer test`: Limpia caches y ejecuta tests

## CI/CD
Actualmente desactivado para desarrollo individual. Flujo local recomendado en `docs/ci-cd.md`.

## Roles y Permisos (Spatie)
- Paquete: `spatie/laravel-permission` integrado.
- Props compartidas por Inertia desde `App\\Http\\Middleware\\HandleInertiaRequests`:
  - `auth.user`: usuario autenticado
  - `auth.roles`: string[] con los roles del usuario
  - `auth.permissions`: string[] con permisos agregados

Documentación completa: `docs/permissions.md`.

### Ejemplo de UI (Dashboard)
- `resources/js/pages/dashboard.tsx`: muestra los roles y un gate simple que sólo renderiza una sección si el usuario tiene rol `admin` o `root`.

### Ruta protegida por rol
- Ruta de ejemplo en `routes/web.php` dentro del grupo `auth` + `verified`:

```php
Route::get('admin-only', function () {
    return response('Admin area', 200);
})->middleware(['role:admin|root'])->name('admin.only');
```

### Middlewares registrados
- En `bootstrap/app.php` se registran los alias de Spatie:
  - `role`, `permission`, `role_or_permission`.

### Comando de instalación y caché de permisos
- `php artisan app:install` ejecuta `permission:cache-reset` al final para limpiar la caché de permisos/roles.

## Convenciones
- Commits: Conventional Commits
- Estilo PHP: PSR-12 (Laravel Pint)
- TypeScript estricto (evitar `any` no tipado)

## Roadmap
Ver `ROADMAP.md`. Trabajo por fases (F1–F6). Issues vinculadas en GitHub.

## Documentación
- `docs/permissions.md`: Roles y permisos (Spatie)
- `docs/testing.md`: Testing (Pest, coverage, component tests)
- `docs/ci-cd.md`: CI/CD (Actions, checks requeridos, branch protection)
- `docs/frontend.md`: Frontend (Inertia 2, shadcn/ui, Tailwind 4)
