---
description: Testing Rules & Standards
auto_execution_mode: 1
---

# Testing Rules & Standards

<testing_structure>

- Usar Pest para backend testing (más expresivo que PHPUnit)
- Implementar Vitest para frontend testing
- Definir proper test organization
- Usar proper test naming conventions
- Implementar test databases apropiadas
- Definir proper test data setup/teardown
  </testing_structure>

<pest_setup>

- Instalar: composer require pestphp/pest-plugin-laravel --dev
- Inicializar: php artisan pest:install
- Generar tests: php artisan pest:test UserTest --feature
- Usar describe/it patterns para mejor legibilidad
- Implementar proper dataset testing
- Definir custom expectations cuando sea necesario
  </pest_setup>

<backend_testing>

- Escribir Feature tests para workflows completos
- Implementar Unit tests para lógica compleja
- Usar proper database transactions en tests
- Definir proper test factories
- Implementar proper mocking strategies
- Usar proper assertion methods
  </backend_testing>

<frontend_testing>

- Implementar component testing con React Testing Library
- Definir proper user interaction tests
- Usar proper mocking para API calls
- Implementar snapshot testing para UI consistency
- Definir proper accessibility testing
- Usar proper async testing patterns
  </frontend_testing>

<testing_best_practices>

- Seguir AAA pattern (Arrange, Act, Assert)
- Escribir tests descriptivos y maintainables
- Implementar proper test coverage goals
- Definir proper CI/CD testing workflows
- Usar proper test environments
- Implementar proper performance testing
  </testing_best_practices>
