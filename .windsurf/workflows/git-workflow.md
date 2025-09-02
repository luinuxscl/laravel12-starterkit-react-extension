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

- main: código estable para releases (solo cuando corresponda)
- develop: rama troncal de integración (commits directos permitidos para cambios pequeños)
- feature/*: para features medianas/grandes (1 PR a la vez)
- fix/*: bug fixes
- hotfix/*: fixes de producción (cuando exista producción)
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

- Cambios pequeños: commit directo a `develop` (Conventional Commits)
- Cambios medianos/grandes: `feature/*` → PR opcional hacia `develop`
- No acumular PRs: mergear/cerrar antes de abrir otro
- Documentación: actualizar en `docs/*` y enlazar desde `README.md`
- Releases: cuando aplique, cortar release desde `develop` a `main` con tag
  </solo_dev_flow>
