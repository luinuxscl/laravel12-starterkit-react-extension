---
description: Laravel 12 Core Development Rules
auto_execution_mode: 1
---

# Laravel 12 Core Development Rules

<artisan_commands>

- SIEMPRE usar comandos artisan como base para generación de código
- php artisan make:model {Model} -mfr (model + migration + factory + resource)
- php artisan make:controller {Controller} --resource
- php artisan make:request {FormRequest} para validación
- php artisan make:command {Command} para comandos custom
- php artisan make:seeder {Seeder} para datos iniciales
- Customizar desde el código generado, no crear desde cero
  </artisan_commands>

<laravel_standards>

- Usar Laravel 12 syntax y features más recientes
- Seguir PSR-12 coding standards
- Implementar Service Providers para funcionalidades complejas
- Usar Form Requests para validación
- Implementar Resources para transformación de datos API
- Usar Jobs para procesos asíncronos
- Implementar Middleware para lógica transversal
  </laravel_standards>

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
