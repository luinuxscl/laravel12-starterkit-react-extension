import type { Auth } from '@/types';

export function hasRole(auth: Auth | undefined, role: string): boolean {
  if (!auth) return false;
  return (auth.roles ?? []).includes(role);
}

export function hasAnyRole(auth: Auth | undefined, roles: string[]): boolean {
  if (!auth) return false;
  const userRoles = new Set(auth.roles ?? []);
  return roles.some((r) => userRoles.has(r));
}

export function hasPermission(auth: Auth | undefined, permission: string): boolean {
  if (!auth) return false;
  return (auth.permissions ?? []).includes(permission);
}

export function hasAnyPermission(auth: Auth | undefined, permissions: string[]): boolean {
  if (!auth) return false;
  const userPerms = new Set(auth.permissions ?? []);
  return permissions.some((p) => userPerms.has(p));
}
