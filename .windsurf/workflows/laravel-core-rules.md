---
description: Laravel 12 Core Development Rules
auto_execution_mode: 1
---

# Laravel 12 Core Development Rules

<laravel_boost_integration>

- Usar search-docs tool ANTES de cualquier implementación
- Usar tinker tool para debugging y queries Eloquent directas
- Usar database-query tool para queries de solo lectura
- Usar browser-logs tool para debugging frontend
- Usar get-absolute-url tool para URLs del proyecto
- Usar list-artisan-commands tool antes de ejecutar comandos artisan
  </laravel_boost_integration>

<artisan_commands>

- SIEMPRE usar comandos artisan como base para generación de código
- php artisan make:model {Model} -mfr (model + migration + factory + resource)
- php artisan make:controller {Controller} --resource
- php artisan make:request {FormRequest} para validación
- php artisan make:command {Command} para comandos custom
- php artisan make:seeder {Seeder} para datos iniciales
- php artisan make:test --pest {TestName} para tests con Pest
- Pasar --no-interaction a todos los comandos artisan
- Customizar desde el código generado, no crear desde cero
  </artisan_commands>

<laravel12_structure>

- NO crear archivos en app/Http/Middleware/ (deprecated)
- Registrar middleware en bootstrap/app.php
- Service providers en bootstrap/providers.php
- NO usar app/Console/Kernel.php (deprecated)
- Commands auto-register desde app/Console/Commands/
- Configurar consola en bootstrap/app.php o routes/console.php
  </laravel12_structure>

<php_standards>

- Usar PHP 8.3+ constructor property promotion
- Explicit return types en TODOS los métodos
- Type hints apropiados en parámetros
- PHPDoc blocks sobre comments inline
- Ejecutar vendor/bin/pint --dirty antes de commits
  </php_standards>

<routing_guidelines>

- Usar Route Model Binding cuando sea posible
- Agrupar rutas relacionadas con Route::group()
- Implementar rate limiting en APIs
- Usar named routes para mejor mantenibilidad
- Separar rutas web de API claramente
  </routing_guidelines>

<controller_patterns>

- Un controller por recurso principal
- Máximo 7 métodos por controller (RESTful)
- Usar dependency injection en constructores
- Validar requests con Form Request classes
- Retornar Inertia responses para páginas web
- Retornar JSON resources para APIs
  </controller_patterns>

<model_conventions>

- Un modelo por tabla de base de datos
- Definir fillable o guarded apropiadamente
- Implementar relationships con naming claro
- Usar accessors/mutators para transformaciones
- Implementar scopes para queries comunes
- Definir casts para atributos especiales
  </model_conventions>
