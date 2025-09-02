// Centralizador de rutas de frontend para evitar strings hardcodeados
// Mantén sólo helpers necesarios y añade conforme crezcan las vistas

export const routes = {
  users: {
    index: () => `/users`,
    create: () => `/users/create`,
    show: (id: number | string) => `/users/${id}`,
    edit: (id: number | string) => `/users/${id}/edit`,
    delete: (id: number | string) => `/users/${id}`,
  },
} as const;
