---
description: Database Migrations & Models Rules
auto_execution_mode: 1
---

# Database Migrations & Models Rules

<migration_standards>

- Usar descriptive migration names con timestamps
- Implementar proper rollback methods
- Definir proper indexes para performance
- Usar foreign key constraints apropiadamente
- Implementar proper column naming conventions
- Definir proper default values
- SIEMPRE usar php artisan make:migration como punto de partida
  </migration_standards>

<system_seeders>

- Crear BaseSystemSeeder que ejecute todos los seeders críticos
- RoleSeeder: roles root, admin, standard con spatie/permission
- UserSeeder: crear usuario root inicial con email/password seguros
- PermissionSeeder: definir permisos granulares del sistema
- ConfigSeeder: configuraciones por defecto (idiomas, timezone, etc.)
- Ejecutar vía comando de instalación: php artisan db:seed --class=BaseSystemSeeder
  </system_seeders>

<model_relationships>

- Definir relationships con naming claro
- Usar proper relationship types (hasOne, hasMany, etc.)
- Implementar eager loading para N+1 prevention
- Definir proper relationship constraints
- Usar polymorphic relationships cuando apropiado
- Implementar proper relationship caching
  </model_relationships>

<query_optimization>

- Usar Query Builder para queries complejas
- Implementar proper indexing strategies
- Definir scopes para queries comunes
- Usar proper pagination para large datasets
- Implementar proper eager loading
- Definir proper database transactions
  </query_optimization>

<seeding_strategies>

- Usar factories para test data
- Implementar proper seeding order
- Definir realistic fake data
- Usar proper seeding for different environments
- Implementar proper data relationships en seeders
- Definir proper cleanup strategies
  </seeding_strategies>
