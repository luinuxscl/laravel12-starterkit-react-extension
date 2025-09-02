# Autorización (Policies + Frontend)

Este proyecto usa Laravel Policies junto con roles de `spatie/laravel-permission` para controlar el acceso.

## UserPolicy
Archivo: `app/Policies/UserPolicy.php`

- `viewAny(User)`: `root` y `admin` pueden listar usuarios.
- `view(User, User)`: `root`/`admin` o el propio usuario.
- `create(User)`: `root` y `admin`.
- `update(User, User)`: `root`/`admin` o el propio usuario.
- `delete(User, User)`: `root` y `admin` (nunca auto-eliminación).
- `restore`/`forceDelete`: solo `root`.

Tests: `tests/Feature/Policies/UserPolicyTest.php`.

## Roles disponibles
Definidos por `Database\Seeders\BaseSystemSeeder`:

- `root`
- `admin`
- `standard`

## Datos compartidos a Frontend
En `App\Http\Middleware\HandleInertiaRequests` se comparten:

```php
'auth' => [
  'user' => $user,
  'roles' => $user ? $user->getRoleNames()->toArray() : [],
  'permissions' => $user ? $user->getAllPermissions()->pluck('name')->toArray() : [],
],
```

## Helper de autorización (React)
Archivo: `resources/js/lib/auth.ts`

- `hasRole(auth, role)`
- `hasAnyRole(auth, roles: string[])`
- `hasPermission(auth, permission)`
- `hasAnyPermission(auth, permissions: string[])`

Ejemplo de uso en `resources/js/pages/dashboard.tsx`:

```tsx
import { hasAnyRole } from '@/lib/auth';

{hasAnyRole(auth, ['admin', 'root']) && (
  <div>Sección visible solo para admin/root</div>
)}
```

## Recomendaciones
- Ocultar botones/acciones en UI según roles o permisos relevantes.
- Validar acciones críticas en backend con `this->authorize()` o middlewares (`can:*`).
- Mantener las Policies como única fuente de verdad para reglas de acceso.

## Próximos pasos
- Añadir políticas para otros modelos según necesidades.
- Exponer permisos específicos si se definen a futuro (además de roles).
