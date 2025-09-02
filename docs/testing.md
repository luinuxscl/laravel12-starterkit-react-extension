# Testing

Guía de pruebas para el starter kit. Objetivo: 80%+ coverage, CI estable.

## Backend (Pest v4)
- Ejecutar local:
```bash
composer test        # alias que limpia cachés y corre Pest
./vendor/bin/pest    # directo
```
- Estructura:
  - `tests/Feature/` flujos completos (auth, permisos, settings…)
  - `tests/Unit/` lógica aislada
- Recomendaciones:
  - Usa datasets para múltiples escenarios
  - Usa factories y seeders mínimos
  - Evita tocar disco/red salvo necesidad

## Frontend
- Vitest + React Testing Library (recomendado)
  - Ubicar specs cerca del componente: `Component.test.tsx`
  - Testear UI states y accesibilidad (roles/labels)

## Cobertura
- Backend (Pest + Xdebug en CI):
```bash
./vendor/bin/pest --coverage --min=80
```
- Frontend (Vitest):
```bash
npm run test -- --coverage
```

## Prácticas
- Usa `given/when/then` en descripciones
- Evita mocks globales excesivos; delimítalos por test
- Añade pruebas primero en bugs reproducibles

## Integración con CI
- `tests.yml` ejecuta Pest tras build y migraciones SQLite
- Subir umbral gradualmente (70→80→85) para no bloquear iteraciones tempranas
