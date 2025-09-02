# Frontend: React 19 + Inertia 2 + shadcn/ui + Tailwind 4

Guía rápida para el frontend del starter kit.

## Estructura
- Código en `resources/js/`
- Componentes UI con shadcn/ui + Radix
- Tipos en `resources/js/types/`
- Utilidades en `resources/js/lib/`

## Inertia 2
- Props compartidas: autenticación, roles/permisos (`HandleInertiaRequests`).
- Buenas prácticas:
  - `useForm` para formularios
  - `Link` con `prefetch`
  - `deferred props` para cargas pesadas
  - `polling` para datos en vivo

## UI y estilos
- Tailwind 4: usa `@import` en `resources/css/app.css`
- shadcn/ui: componentes accesibles y composables
- Recomendaciones:
  - Componentes pequeños y tipados
  - Reutilizar tokens/variables de diseño

## Rendimiento
- `React.lazy` para code splitting
- Evitar renders innecesarios (memoización donde aplique)
- Carga diferida de recursos no críticos

## Testing de componentes
- Vitest + RTL
- Testear estados, accesibilidad y eventos

## i18n
- Usa `__()` helper desde backend con fallback a inglés
- Componer textos desde props compartidas o endpoints dedicados

## Seguridad
- CSRF automático con Inertia/Laravel
- Validaciones en backend + feedback en UI
- Autorización en Policies y gates (no en componentes)

## Datos de usuarios (UserResource)
- El backend expone usuarios mediante `App\\Http\\Resources\\UserResource`.
- Estructura estándar para cada usuario:
  - `id: number`
  - `name: string`
  - `email: string`
- Listado paginado (`users.index`): prop `users` incluye:
  - `data: User[]`
  - `links: PaginationLink[]` y metadatos habituales de Laravel
- Detalle (`users.show` y `users.edit`): prop `user: User` con la estructura anterior.
