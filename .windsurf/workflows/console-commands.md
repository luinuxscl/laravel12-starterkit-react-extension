---
description: Console Commands Development Rules
auto_execution_mode: 1
---

# Console Commands Development Rules

<command_creation>

- Usar php artisan make:command como base
- Nombrar comandos con namespace: app:install, system:backup, users:promote
- Definir signature clara con argumentos y opciones
- Implementar proper error handling y feedback
- Usar progress bars para operaciones largas
- Definir proper exit codes (0 = success, 1+ = error)
  </command_creation>

<installation_command>

- php artisan app:install como comando principal
- Ejecutar migrate:fresh, db:seed, optimizations
- Crear usuario root si no existe
- Configurar permisos y cache
- Mostrar información de instalación completada
- Permitir flags: --demo-data, --reset-permissions, etc.
  </installation_command>

<system_commands>

- app:backup: respaldo completo del sistema
- system:optimize: optimizaciones de performance
- users:promote {user} --role={role}: gestión de roles
- cache:warm: pre-cargar caches críticos
- queue:monitor: monitoreo de colas
- logs:cleanup --days={days}: limpieza de logs
  </system_commands>

<command_patterns>

- Usar dependency injection en constructores
- Implementar proper validation de inputs
- Definir descriptive help text
- Usar proper output formatting (info, error, warn, line)
- Implementar confirmation prompts para acciones destructivas
- Log todas las operaciones críticas
  </command_patterns>
