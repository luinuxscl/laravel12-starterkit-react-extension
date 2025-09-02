---
description: Inertia 2 Integration Rules
auto_execution_mode: 1
---

# Inertia 2 Integration Rules

<inertia_patterns>

- Components en resources/js/Pages (NO cambiar sin aprobación)
- Usar Inertia::render() en controllers para páginas
- Implementar proper page props typing
- Usar Inertia::share() para datos globales
- Usar router.visit() o <Link> para navegación (NO traditional links)
- Definir proper progress indicators
  </inertia_patterns>

<inertia_v2_features>

- Polling: actualización automática de datos
- Prefetching: pre-cargar páginas en hover/focus
- Deferred props: cargar datos pesados asíncronamente
- Infinite scrolling: merging props con WhenVisible
- Lazy loading: datos on-demand en scroll
- Form component: método recomendado para formularios
  </inertia_v2_features>

<deferred_props>

- Usar para datos que toman tiempo en cargar
- Implementar skeleton/empty states con animación
- Pattern: cargar página rápido, datos después
- Mostrar loading states apropiados
- Definir proper error handling para deferred data
  </deferred_props>

<form_handling>

- PREFERIR <Form> component sobre useForm
- <Form> incluye: errors, processing, wasSuccessful, recentlySuccessful
- Opciones: resetOnError, resetOnSuccess, setDefaultsOnSuccess
- useForm para control programático o conventions existentes
- Implementar proper validation error display
- Usar progress tracking para uploads
  </form_handling>

<navigation_patterns>

- import { Link } from '@inertiajs/react'
- <Link href="/">Home</Link> para navegación estándar
- router.visit() para navegación programática
- Usar route() helper en frontend con proper typing
- Implementar proper 404 handling
- Definir proper title management per page
  </navigation_patterns>
