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

Asignación de permisos por rol (determinística con `syncPermissions()`):

- `root`: todos los permisos `users.*`
- `admin`: `users.viewAny`, `users.view`, `users.create`, `users.update`, `users.delete`
- `standard`: sin permisos `users.*` por defecto (puede verse/editarse a sí mismo vía Policy)

Modelo de permisos actual (`users.*`):

- `users.viewAny`: listar usuarios
- `users.view`: ver perfil de otro usuario
- `users.create`: crear usuarios
- `users.update`: actualizar usuarios ajenos
- `users.delete`: eliminar usuarios ajenos (nunca auto-eliminar)

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

## Helpers de permisos en React

Usar `hasPermission()` con fallback por roles cuando aplique (ej. admin/root) para compatibilidad:

```ts
import { hasPermission } from '@/lib/permissions'
import { hasAnyRole } from '@/lib/auth'

const canCreate = hasPermission(auth, 'users.create') || hasAnyRole(auth, ['admin','root'])
const canUpdate = hasPermission(auth, 'users.update') || hasAnyRole(auth, ['admin','root'])
```

Ejemplos en:

- `resources/js/pages/users/index.tsx` (crear/editar/eliminar)
- `resources/js/pages/users/create.tsx` (submit deshabilitado si no hay permiso)
- `resources/js/pages/users/edit.tsx` (submit deshabilitado; roles visibles solo si puede)

## Protección de rutas
`routes/web.php` (agrupada bajo `auth` + `verified`):
```php
Route::get('admin-only', function () {
    return response('Admin area', 200);
})->middleware(['role:admin|root'])->name('admin.only');
```

Para policies basadas en permisos, proteger controladores con `authorizeResource` (ya aplicado) y definir lógica en la Policy.

## Policies (Laravel)

`app/Policies/UserPolicy.php` valida permisos `users.*` con reglas especiales:

```php
public function viewAny(User $user): bool
{
    return $user->can('users.viewAny') || $user->hasRole('root');
}

public function view(User $user, User $model): bool
{
    if ($user->id === $model->id) return true; // self-view permitido
    return $user->can('users.view') || $user->hasRole('root');
}

public function update(User $user, User $model): bool
{
    if ($user->id === $model->id) return true; // self-update permitido
    return $user->can('users.update') || $user->hasRole('root');
}

public function delete(User $user, User $model): bool
{
    if ($user->id === $model->id) return false; // no auto-eliminar
    return $user->can('users.delete') || $user->hasRole('root');
}
```

## Tests (Pest)
- Sembrar roles antes de asignarlos:
```php
use Database\Seeders\BaseSystemSeeder;
use function Pest\Laravel\artisan;

artisan('db:seed', ['--class' => BaseSystemSeeder::class])->assertSuccessful();
```
- Ver ejemplos en `tests/Feature/Permissions/`.
- Ver validaciones de Policy en `tests/Feature/Policies/` (incluye casos 403/200 y reglas especiales).

## Troubleshooting
- Cambié roles/permisos y no se reflejan: ejecutar `php artisan permission:cache-reset`.
- Conflictos de documentación: actualizar solo este archivo y enlazar desde `README.md`.

Comandos útiles:

- Reset cache: `php artisan permission:cache-reset`
- Ver permisos/roles de un usuario en tinker:
  ```php
  $u = \App\Models\User::first();
  $u->getRoleNames();
  $u->getAllPermissions()->pluck('name');
  ```

## Buenas prácticas
- Usar middleware `role:`/`permission:` para rutas.
- Validar acciones con Policies para lógica de autorización más compleja.
- Mantener nombres de roles en minúsculas y consistentes.
- Evitar lógica de autorización en componentes; preferir helpers/gates centralizados.
