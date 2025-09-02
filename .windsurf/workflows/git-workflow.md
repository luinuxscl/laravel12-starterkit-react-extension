---
description: Git Workflow & Commit Standards
auto_execution_mode: 1
---

# Git Workflow & Commit Standards

> Nota: Este repositorio opera sin GitHub Actions durante la fase de desarrollo individual. Los PRs y revisiones son opcionales; los checks de calidad se ejecutan localmente (Pint, ESLint, Pest).

<commit_conventions>

- Usar Conventional Commits format
- Prefijos: feat:, fix:, docs:, style:, refactor:, test:, chore:
- Escribir commit messages descriptivos
- Usar imperative mood en subject line
- Incluir issue numbers cuando aplicable
- Mantener commits atómicos y enfocados
  </commit_conventions>

<branch_strategy>

- main: rama base única para trabajo en serie (estrategia v1)
- feature/*: una feature pequeña a la vez; PR corto (draft desde el inicio)
- fix/*: bug fixes puntuales
- hotfix/*: solo si hay producción
- Convención de nombres: kebab-case claro y corto (ej. `feature/policies-crud`)
  </branch_strategy>

<mcp_integration>

- Usar Git MCP para operaciones locales de git (status, add, commit, push)
- No usar workflows automatizados (Actions desactivado en desarrollo)
- Hooks opcionales (pre-commit/pre-push) para lint/format si se desea
- Code review opcional (auto-revisión) antes de merges significativos
- Estrategia de despliegue: definir más adelante al pasar a QA/producción
  </mcp_integration>

<code_quality>

- Ejecutar localmente antes de push cuando el cambio sea relevante:
  - `vendor/bin/pint --test`
  - `npm run lint`
  - `./vendor/bin/pest`
- Hooks opcionales: pre-commit (formato) y pre-push (lint/tests) si no entorpecen el flujo
- Formato: Prettier (frontend) y Laravel Pint (PHP) siguiendo PSR-12
- Dependencias: `composer install` / `npm ci` cuando cambien
- Seguridad: validar inputs y autorización en backend (no dependemos de escaneos CI por ahora)
  </code_quality>

<solo_dev_flow>

- Flujo en serie: `main` → `feature/*` → PR (draft) → tests → squash merge → borrar rama
- Crear rama siempre desde `main` actualizado (`git checkout main && git pull`)
- Pushear temprano; actualizar el PR draft con contexto
- Documentar durante el feature en `docs/*`; evitar `README.md` hasta cierre de fase
- Antes de push/merge: `git fetch origin && git rebase origin/main`
- Tras merge: empezar la siguiente feature desde `main`
  </solo_dev_flow>

<anti_conflicts_v1>

- Config Git recomendada (global):
  - `git config --global pull.rebase true`
  - `git config --global rebase.autoStash true`
  - `git config --global rerere.enabled true`
  - `git config --global alias.ffmerge "merge --ff-only"`
- Evitar ramas paralelas salvo casos puntuales (experimentos/hotfix)
- No mezclar cambios de dependencias/lockfiles con código funcional
- Evitar refactors masivos en paralelo a features; planificar PR dedicado
- Merge por “Squash and merge” en GitHub para mantener historial atómico
  </anti_conflicts_v1>
