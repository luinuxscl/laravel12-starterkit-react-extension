---
description: Git Workflow & Commit Standards
auto_execution_mode: 1
---

# Git Workflow & Commit Standards

<commit_conventions>

- Usar Conventional Commits format
- Prefijos: feat:, fix:, docs:, style:, refactor:, test:, chore:
- Escribir commit messages descriptivos
- Usar imperative mood en subject line
- Incluir issue numbers cuando aplicable
- Mantener commits atómicos y enfocados
  </commit_conventions>

<branch_strategy>

- main: production ready code
- develop: integration branch
- feature/\*: nuevas features
- fix/\*: bug fixes
- hotfix/\*: production fixes
- Usar proper branch naming conventions
  </branch_strategy>

<mcp_integration>

- Usar Git MCP para operaciones de git
- Implementar GitHub MCP para PR management
- Definir proper automated workflows
- Usar proper commit hooks
- Implementar proper code review processes
- Definir proper deployment strategies
  </mcp_integration>

<code_quality>

- Ejecutar linting antes de commits
- Implementar proper pre-commit hooks
- Usar proper code formatting (Prettier, PHP-CS-Fixer)
- Definir proper CI/CD quality gates
- Implementar proper dependency management
- Usar proper security scanning
  </code_quality>
