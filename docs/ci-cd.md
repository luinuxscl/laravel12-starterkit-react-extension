# CI/CD (GitHub Actions)

Guía para pipelines estables y rápidos.

## Workflows
- `/.github/workflows/tests.yml`
  - PHP 8.3, Node 22
  - `composer install`, `npm ci`, build, `.env`, `php artisan key:generate`
  - SQLite in-memory/file y `php artisan migrate --graceful`
  - `./vendor/bin/pest`
- `/.github/workflows/lint.yml`
  - Pint, Prettier, ESLint

Ambos soportan `workflow_dispatch` para ejecución manual.

## Required checks
Configura en GitHub → Settings → Branches → Branch protection rules (develop/main):
- Require status checks to pass before merging
  - Selecciona: `tests`, `linter`
- Require linear history (opcional)
- Require pull request reviews before merging (opcional)

## Estrategia de ramas
- `main`: estable, releases
- `develop`: integración diaria
- `feature/*`: cambios pequeños (1–2 días). Rebase contra `develop` frecuente.

## Consejos de rendimiento
- Usa caches de `actions/setup-node` y Composer si aumenta el tiempo de pipeline
- Evita instalar dev tools innecesarios
- Ejecuta `npm run build` en tests.yml sólo si hay cambios en frontend (regla opcional)

## Troubleshooting
- Checks no aparecen en el PR pero Actions está verde:
  - Asegura “Required checks” configurados (arriba)
  - Ejecuta manualmente con `workflow_dispatch`
  - Cierra/reabre el PR o haz un commit vacío para re-disparar
- Permisos:
  - Settings → Actions → General: Allow all actions; GITHUB_TOKEN con read/write si lo requiere tu workflow
