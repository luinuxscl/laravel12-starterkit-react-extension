# CI/CD (estado actual: desactivado)

Este proyecto está en desarrollo y se trabaja en modalidad individual, por lo que se ha optado por NO usar GitHub Actions de forma automática.

## Reglas vigentes
- No hay checks requeridos en `develop`/`main`.
- No hay workflows activos en `/.github/workflows/`.

## Flujo local recomendado
- Antes de hacer push (cambios relevantes):
  - `vendor/bin/pint --test`
  - `npm run lint`
  - `./vendor/bin/pest`
- Commits directos a `develop` para cambios pequeños.
- PRs solo para features medianas/grandes o tareas de documentación específicas.

## Cómo reactivar CI más adelante
1) Restaurar un workflow unificado `/.github/workflows/ci.yml` con un único status `ci` (ver historial del repo para un ejemplo reciente).
2) Activar Actions en GitHub: Settings → Actions → habilitar.
3) Branch protection (opcional): Settings → Branches → agregar regla y marcar `ci` como Required check.
4) (Opcional) Habilitar Auto-merge en los PRs.

## Nota
Cuando el proyecto avance a QA/producción, se recomienda reactivar CI con el pipeline unificado y checks mínimos.

## Estrategia anti-conflictos (v1)

Flujo en serie, sin ramas paralelas por defecto. Pensado para ciclos de horas.

- Objetivo: features pequeñas, PRs cortos, divergencia mínima.
- Rama base: `main`.

### Operativa
- Crear rama desde `main` recién actualizado:
  - `git checkout main && git pull`
  - `git checkout -b feature/mi-feature`
- Abrir PR como draft al iniciar; pushear temprano y frecuente.
- Documentación durante el feature en `docs/*`; evitar tocar `README.md` salvo al cerrar fase.
- Antes de cada push/merge:
  - `git fetch origin && git rebase origin/main`
- Tests locales obligatorios:
  - `vendor/bin/pint --test`
  - `npm run lint`
  - `./vendor/bin/pest`
- Merge: “Squash and merge”, borrar rama, siguiente feature.

### Reglas Git
- Rebase por defecto y estado limpio:
  - `git config --global pull.rebase true`
  - `git config --global rebase.autoStash true`
  - `git config --global rerere.enabled true`
- Fast-forward-only hacia `main` (para merges locales):
  - Alias recomendado: `git config --global alias.ffmerge "merge --ff-only"`
- Mensajes de commit en español (Conventional Commits):
  - Plantilla: `.github/commit-message-template.md`
  - Activar plantilla local: `git config commit.template .github/commit-message-template.md`

### Separación de cambios para evitar colisiones
- Evitar editar `README.md` en múltiples features. Centralizar en un PR de cierre de fase.
- No mezclar cambios de dependencias/lockfiles con código; usar PR dedicado cuando corresponda.
- Evitar refactors masivos en paralelo a features; planificar ventana y PR exclusivos.

Con este enfoque, los conflictos tienden a cero porque reducimos la divergencia temporal y aislamos archivos de alta colisión.

## Estrategia anti-conflictos (v2 – develop como rama de integración)

Para más control: `main` solo se actualiza desde `develop`.

### Ramas
- `main`: estable. Solo merge desde `develop`.
- `develop`: integración continua de features.
- `feature/*`: una feature a la vez, nace desde `develop`.

### Flujo
1) Crear feature
   - `git checkout develop && git pull`
   - `git checkout -b feature/nombre-corto`
   - Abrir PR como draft hacia `develop` y pushear temprano.
2) Trabajo y pruebas
   - Rebase frecuente: `git fetch origin && git rebase origin/develop`
   - Checks locales: `vendor/bin/pint --test`, `npm run lint`, `./vendor/bin/pest`
3) Merge a `develop`
   - PR pequeño, “Squash and merge”. Borrar rama feature.
4) Validación en `develop`
   - Smoke tests + “uso real” guiado de flujos críticos.
5) Promoción a `main`
   - Fast-forward-only o rebase de `develop` → `main`.
   - Tag de release (ej. `v0.2.0`).

### Reglas clave
- Rebase obligatorio antes de push/merge (feature→develop con `origin/develop`).
- Separar docs y dependencias en PRs dedicados.
- Mensajes de commit en español (plantilla en `.github/commit-message-template.md`).

Ventajas: aísla `main`, reduce conflictos y permite validar en `develop` antes del release.
