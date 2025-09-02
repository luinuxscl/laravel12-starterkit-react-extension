# CI/CD (estado actual: desactivado)

Este proyecto está en desarrollo y se trabaja en modalidad individual, por lo que se ha optado por NO usar GitHub Actions de forma automática.

## Reglas vigentes
- No hay checks requeridos en `develop`/`main`.
- Los workflows `/.github/workflows/tests.yml` y `/.github/workflows/lint.yml` existen solo para ejecución manual (`workflow_dispatch`) si alguna vez deseas usarlos puntualmente.

## Flujo local recomendado
- Antes de hacer push (cambios relevantes):
  - `vendor/bin/pint --test`
  - `npm run lint`
  - `./vendor/bin/pest`
- Commits directos a `develop` para cambios pequeños.
- PRs solo para features medianas/grandes o tareas de documentación específicas.

## Cómo reactivar CI más adelante
1) Crear o restaurar un workflow unificado `/.github/workflows/ci.yml` con un único status `ci` (ver historial del repo para un ejemplo reciente).
2) Activar Actions en GitHub: Settings → Actions → habilitar.
3) Branch protection (opcional): Settings → Branches → agregar regla y marcar `ci` como Required check.
4) (Opcional) Habilitar Auto-merge en los PRs.

## Nota
Mantener los workflows como manuales permite activarlos sin reintroducir complejidad. Cuando el proyecto avance a QA/producción, recomienda reactivar el pipeline unificado y checks mínimos.
