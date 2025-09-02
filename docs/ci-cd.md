# CI/CD (GitHub Actions)

Pipeline unificado, rápido y simple para trabajo en solitario.

## Workflow único
- `/.github/workflows/ci.yml` (único status: `ci`)
  - Dispara en `push` y `pull_request` para `develop`, `main`, `feature/**`, `docs/**`.
  - Ignora cambios en `docs/**` y `README.md` (no corre CI pesado para docs-only).
  - Concurrency: cancela ejecuciones previas en la misma rama.
  - Pasos:
    - PHP 8.3 + Node 22
    - Composer + npm ci
    - Build de assets
    - `.env` + `key:generate`
    - Migraciones SQLite (`migrate --graceful`)
    - Pint `--test`, ESLint, Pest

Workflows previos quedan manuales:
- `/.github/workflows/tests.yml` y `/.github/workflows/lint.yml` → sólo `workflow_dispatch` por si necesitas ejecutarlos aislados.

## Required checks (Branch protection)
Configura en GitHub → Settings → Branches → Branch protection rules (develop/main):
- Require status checks to pass before merging → Selecciona solo: `ci`.
- Enable auto-merge (opcional) para que los PRs se fusionen automáticamente al pasar `ci`.
- Require linear history (opcional).

## Estrategia de ramas
- `develop`: rama de integración. Commits directos permitidos si el cambio es pequeño.
- `feature/*`: para features medianas; máximo 1 PR abierto. Rebase frecuente.
- `docs/*`: cambios de documentación.

## Tips de rendimiento
- Usa `[skip ci]` en commits triviales de docs si no quieres correr CI.
- Mantén dependencias al mínimo y utiliza cachés de npm/composer (ya habilitado).

## Troubleshooting
- Checks no aparecen:
  - Ejecuta manualmente `ci` con `workflow_dispatch`.
  - Haz un commit vacío para re-disparar: `git commit --allow-empty -m "chore(ci): trigger" && git push`.
- Permisos:
  - Settings → Actions → General: permitir GitHub Actions y GITHUB_TOKEN por defecto.
