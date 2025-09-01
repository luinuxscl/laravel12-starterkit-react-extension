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
  </shadcn_standards>

<component_composition>

- Componer components complejos desde primitivos
- Usar compound component patterns cuando apropiado
- Implementar proper forwarding refs
- Definir proper default props
- Usar proper component composition
- Implementar proper polymorphic components
  </component_composition>

<tailwind_usage>

- Usar Tailwind 4 syntax y features
- Definir custom utilities en `tailwind.config.js`
- Usar CSS variables para theming
- Implementar proper responsive design
- Usar proper spacing scales
- Definir proper color palettes
  </tailwind_usage>

<accessibility>
- Implementar proper ARIA labels
- Usar semantic HTML elements
- Definir proper focus management
- Implementar keyboard navigation
- Usar proper color contrast
- Definir proper screen reader support
</accessibility>

<theming>
- Usar CSS variables para colors
- Implementar dark/light mode support
- Definir proper theme switching
- Usar proper system preference detection
- Implement proper theme persistence
- Definir consistent spacing/sizing
</theming>
