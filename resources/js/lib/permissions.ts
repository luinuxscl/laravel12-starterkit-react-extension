import type { Auth } from '@/types'

export function hasPermission(auth: Auth, permission: string): boolean {
  return Array.isArray(auth?.permissions) && auth.permissions.includes(permission)
}

export function hasAnyPermission(auth: Auth, permissions: string[]): boolean {
  if (!Array.isArray(permissions) || permissions.length === 0) return false
  return Array.isArray(auth?.permissions) && permissions.some((p) => auth.permissions.includes(p))
}
