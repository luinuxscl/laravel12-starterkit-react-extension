import AppLayout from '@/layouts/app-layout'
import type { Auth } from '@/types'
import { hasAnyRole } from '@/lib/auth'
import { routes } from '@/lib/routes'
import { Head, Link, usePage, router } from '@inertiajs/react'
import { useMemo, useState } from 'react'

type UserItem = { id: number; name: string; email: string }

type PaginationLink = { url: string | null; label: string; active: boolean }
type Paginated<T> = { data: T[]; links?: PaginationLink[] }

type PageProps = {
  auth: Auth
  users: Paginated<UserItem>
  filters?: { q?: string; sort?: 'id' | 'name' | 'email'; dir?: 'asc' | 'desc' }
  flash?: { success?: string; error?: string }
}

export default function UsersIndex({ users, filters }: { users: Paginated<UserItem>; filters?: { q?: string; sort?: 'id' | 'name' | 'email'; dir?: 'asc' | 'desc' } }) {
  const { auth, flash } = usePage<PageProps>().props
  const [q, setQ] = useState<string>(filters?.q ?? '')
  const [deletingId, setDeletingId] = useState<number | null>(null)

  const canManage = useMemo(() => hasAnyRole(auth, ['admin', 'root']), [auth])

  const onSearch = (e: React.FormEvent) => {
    e.preventDefault()
    router.get(routes.users.index(), { q, sort: filters?.sort, dir: filters?.dir }, { preserveState: true, replace: true })
  }

  const onDelete = (u: UserItem) => {
    if (!confirm(`¿Eliminar a ${u.name}? Esta acción no se puede deshacer.`)) return
    setDeletingId(u.id)
    router.delete(routes.users.delete(u.id), {
      preserveScroll: true,
      onFinish: () => setDeletingId(null),
    })
  }

  const toggleSort = (column: 'name' | 'email') => {
    const nextDir: 'asc' | 'desc' = filters?.sort === column && filters?.dir === 'asc' ? 'desc' : 'asc'
    router.get(routes.users.index(), { q: filters?.q ?? '', sort: column, dir: nextDir }, { preserveState: true, replace: true })
  }

  return (
    <AppLayout>
      <Head title="Usuarios" />
      <div className="p-6 space-y-4">
        <div className="flex items-center justify-between gap-4">
          <h1 className="text-2xl font-semibold">Usuarios</h1>
          <form onSubmit={onSearch} className="flex items-center gap-2 ml-auto">
            <input
              value={q}
              onChange={(e) => setQ(e.target.value)}
              placeholder="Buscar nombre o email"
              className="h-9 rounded border px-3 text-sm"
            />
            <button type="submit" className="h-9 rounded bg-gray-900 px-3 text-sm text-white dark:bg-gray-100 dark:text-gray-900">
              Buscar
            </button>
          </form>
          {canManage && (
            <Link href={routes.users.create()} className="text-blue-600 hover:underline whitespace-nowrap">
              Crear
            </Link>
          )}
        </div>

        {/* Toasts globales mostrarán flash; se elimina banner local */}

        <div className="overflow-x-auto rounded border">
          <table className="w-full text-left text-sm">
            <thead className="bg-gray-50 dark:bg-gray-900/40">
              <tr>
                <th className="px-3 py-2 w-20">ID</th>
                <th className="px-3 py-2 cursor-pointer select-none" onClick={() => toggleSort('name')}>
                  <span className="inline-flex items-center gap-1">Nombre{filters?.sort === 'name' ? (filters?.dir === 'asc' ? ' ▲' : ' ▼') : ''}</span>
                </th>
                <th className="px-3 py-2 cursor-pointer select-none" onClick={() => toggleSort('email')}>
                  <span className="inline-flex items-center gap-1">Email{filters?.sort === 'email' ? (filters?.dir === 'asc' ? ' ▲' : ' ▼') : ''}</span>
                </th>
                <th className="px-3 py-2 w-48">Acciones</th>
              </tr>
            </thead>
            <tbody className="divide-y">
              {users.data.map((u) => (
                <tr key={u.id} className="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                  <td className="px-3 py-2">{u.id}</td>
                  <td className="px-3 py-2">{u.name}</td>
                  <td className="px-3 py-2">{u.email}</td>
                  <td className="px-3 py-2">
                    <div className="flex items-center gap-3">
                      <Link href={routes.users.show(u.id)} className="text-blue-600 hover:underline">
                        Ver
                      </Link>
                      {(canManage || auth.user?.id === u.id) && (
                        <Link href={routes.users.edit(u.id)} className="text-blue-600 hover:underline">
                          Editar
                        </Link>
                      )}
                      {canManage && auth.user?.id !== u.id && (
                        <button
                          onClick={() => onDelete(u)}
                          className="text-red-600 hover:underline disabled:opacity-50"
                          disabled={deletingId === u.id}
                        >
                          {deletingId === u.id ? 'Eliminando…' : 'Eliminar'}
                        </button>
                      )}
                    </div>
                  </td>
                </tr>
              ))}
              {users.data.length === 0 && (
                <tr>
                  <td colSpan={4} className="px-3 py-6 text-center text-gray-500">
                    No hay usuarios
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        {users.links && users.links.length > 0 && (
          <nav className="flex flex-wrap items-center gap-2 pt-3" aria-label="Pagination">
            {users.links.map((l, idx) => {
              const label = l.label.replaceAll('&laquo;', '«').replaceAll('&raquo;', '»')
              if (l.url === null) {
                return (
                  <span key={idx} className="rounded border px-3 py-1 text-sm text-gray-400">
                    {label}
                  </span>
                )
              }
              return l.active ? (
                <span key={idx} className="rounded bg-gray-900 px-3 py-1 text-sm text-white dark:bg-gray-100 dark:text-gray-900">
                  {label}
                </span>
              ) : (
                <button
                  key={idx}
                  onClick={() => router.get(l.url!, {}, { preserveState: true, replace: true })}
                  className="rounded border px-3 py-1 text-sm hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  {label}
                </button>
              )
            })}
          </nav>
        )}
      </div>
    </AppLayout>
  )
}
