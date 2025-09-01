---
description: shadcn/ui + Radix UI Component Rules
auto_execution_mode: 1
---

# shadcn/ui + Radix UI Component Rules

<shadcn_standards>

- Usar shadcn/ui components como base
- Customizar via Tailwind classes solamente
- Mantener consistency con design system
- Usar proper semantic HTML
- Implementar proper accessibility attributes
- Definir variants usando class-variance-authority
- Verificar componentes existentes antes de crear nuevos
  </shadcn_standards>

<tailwind_v4_syntax>

- Usar @import "tailwindcss"; NO @tailwind directives
- Utilities deprecated reemplazadas:
    - bg-opacity-_ → bg-black/_
    - text-opacity-_ → text-black/_
    - flex-shrink-_ → shrink-_
    - flex-grow-_ → grow-_
    - overflow-ellipsis → text-ellipsis
- Opacity values siguen siendo numéricos
- corePlugins NO soportado en v4
  </tailwind_v4_syntax>

<spacing_patterns>

- Usar gap utilities para spacing, NO margins
- Ejemplo: <div class="flex gap-8"> en lugar de margins
- Pensar en class placement, order, priority
- Remover clases redundantes
- Agrupar elementos lógicamente
  </spacing_patterns>

<dark_mode>

- Si páginas existentes soportan dark mode, nuevas páginas DEBEN soportarlo
- Usar dark: prefix para styles de dark mode
- Mantener consistency con theme switching existente
- Usar proper system preference detection
  </dark_mode>

<component_patterns>

- Extraer patrones repetidos en components
- Un component por archivo
- Usar PascalCase para nombres
- Props interface = ComponentName + 'Props'
- Default exports para componentes principales
- Implementar proper forwarding refs
  </component_patterns>
