---
description: React 19 + TypeScript Frontend Rules
auto_execution_mode: 1
---

# React 19 + TypeScript Frontend Rules

<react_standards>

- Usar React 19 features y hooks más recientes
- Implementar TypeScript estricto (TSX solamente)
- Usar functional components con hooks
- Implementar proper key props en listas
- Usar React.memo para optimización cuando sea necesario
- Definir PropTypes con TypeScript interfaces
  </react_standards>

<typescript_guidelines>

- Definir interfaces para todos los props
- Usar tipos explícitos, evitar 'any'
- Implementar generic types cuando sea apropiado
- Definir types en `resources/js/types/`
- Usar union types para estados específicos
- Implementar proper return types en funciones
  </typescript_guidelines>

<component_structure>

- Un component por archivo
- Usar PascalCase para nombres de componentes
- Estructura: imports → interfaces → component → export
- Props interface debe tener el nombre del componente + 'Props'
- Usar default exports para componentes principales
- Implementar proper error boundaries
  </component_structure>

<state_management>

- Usar useState para estado local simple
- Implementar useReducer para estado complejo
- Usar useContext para estado global limitado
- Definir custom hooks para lógica reutilizable
- Evitar prop drilling excesivo
- Implementar optimistic updates cuando sea apropiado
  </state_management>

<performance_optimization>

- Usar React.lazy para code splitting
- Implementar useMemo para cálculos costosos
- Usar useCallback para funciones pasadas como props
- Definir loading states apropiados
- Implementar proper error handling
- Usar Suspense para componentes lazy
  </performance_optimization>
