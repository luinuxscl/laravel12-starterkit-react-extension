# Permisos y Roles (Spatie)

Esta guía concentra todo lo referente a `spatie/laravel-permission` para minimizar conflictos en `README.md`.

## Instalación y Configuración
- Paquete: `spatie/laravel-permission`.
- Publicados: `config/permission.php` y migraciones del paquete.
- Modelo `User` usa `Spatie\Permission\Traits\HasRoles`.
- Aliases de middleware en `bootstrap/app.php`:
  - `role`, `permission`, `role_or_permission`.

## Seeding base
- `database/seeders/BaseSystemSeeder.php` crea roles: `root`, `admin`, `standard`.
- `database/seeders/DatabaseSeeder.php` lo invoca.
- Comando de instalación: `php artisan app:install`.
  - Con `--dev` crea usuarios demo con roles.
  - Ejecuta `permission:cache-reset` al final.

## Props compartidas (Inertia)
En `App/Http/Middleware/HandleInertiaRequests` se comparten:
- `auth.user`: usuario autenticado.
- `auth.roles`: string[] con roles del usuario.
- `auth.permissions`: string[] con permisos agregados.

Ejemplo en React (`resources/js/pages/dashboard.tsx`):
```tsx
import { usePage } from '@inertiajs/react';

type Props = {
  auth: {
    user: { name: string } | null;
    roles: string[];
    permissions: string[];
  };
};

export default function Dashboard() {
  const { props } = usePage<Props>();
  const { roles } = props.auth;
  const isAdmin = roles.includes('admin') || roles.includes('root');

  return (
    <div>
      <h1>Dashboard</h1>
      {isAdmin && <div className="mt-4">Sección solo para Admin/Root</div>}
    </div>
  );
}
```

## Protección de rutas
`routes/web.php` (agrupada bajo `auth` + `verified`):
```php
Route::get('admin-only', function () {
    return response('Admin area', 200);
})->middleware(['role:admin|root'])->name('admin.only');
```

## Tests (Pest)
- Sembrar roles antes de asignarlos:
```php
use Database\Seeders\BaseSystemSeeder;
use function Pest\Laravel\artisan;

artisan('db:seed', ['--class' => BaseSystemSeeder::class])->assertSuccessful();
```
- Ver ejemplos en `tests/Feature/Permissions/`.

## Troubleshooting
- Cambié roles/permisos y no se reflejan: ejecutar `php artisan permission:cache-reset`.
- Conflictos de documentación: actualizar solo este archivo y enlazar desde `README.md`.

## Buenas prácticas
- Usar middleware `role:`/`permission:` para rutas.
- Validar acciones con Policies para lógica de autorización más compleja.
- Mantener nombres de roles en minúsculas y consistentes.
- Evitar lógica de autorización en componentes; preferir helpers/gates centralizados.
