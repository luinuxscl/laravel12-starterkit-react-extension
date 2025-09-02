---
description: Testing Rules & Standards
auto_execution_mode: 1
---

# Testing Rules & Standards

<testing_structure>

- Pest v4 YA ESTÁ CONFIGURADO desde la instalación limpia
- NO requiere instalación manual - viene integrado con el starter kit
- Tests Feature en tests/Feature/
- Tests Unit en tests/Unit/
- Browser tests en tests/Browser/ (capacidad Pest v4)
- tests/Pest.php ya configurado con RefreshDatabase por defecto
- TODO cambio debe tener test programático
  </testing_structure>

<pest_v4_ready_features>

- Browser testing: tests/Browser/ para interacciones reales
- Architecture testing: pest-plugin-arch para arquitectura
- Mutation testing: pest-plugin-mutate para quality
- Laravel integration: pest-plugin-laravel con helpers
- Parallel testing: paratest v7.12.0 ya incluido
- Type coverage: verificar tipos TypeScript
  </pest_v4_ready_features>

<immediate_usage>

- php artisan test: ejecutar todos los tests
- php artisan test --parallel: tests en paralelo
- php artisan test tests/Feature/ExampleTest.php: archivo específico
- php artisan test --filter=testName: test específico
- Tests ya migrados desde PHPUnit automáticamente
  </immediate_usage>

<browser_testing>

- Crear tests en tests/Browser/ usando visit() function
- Interactuar: click, type, scroll, select, submit, drag-and-drop
- Verificar: assertSee, assertNoJavascriptErrors, assertNoConsoleLogs
- Usar model factories y RefreshDatabase (ya configurado)
- Test en múltiples browsers cuando sea necesario
  </browser_testing>

<pest_patterns>

- Usar it('should do something', function() {}) syntax
- Datasets para test data con ->with([])
- beforeEach() y afterEach() para setup/cleanup
- Assertions: expect($value)->toBe() style preferido
- Architecture tests: arch()->expects()->toPass()
  </pest_patterns>

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
