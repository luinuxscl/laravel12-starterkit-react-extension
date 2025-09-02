import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import { Head, Link, usePage } from '@inertiajs/react'

type UserItem = { id: number; name: string; email: string }

type PageProps = {
  auth: { user: { id: number } | null; roles: string[] }
  users: UserItem[]
}

export default function UsersIndex({ users }: { users: UserItem[] }) {
  const { auth } = usePage<PageProps>().props

  return (
    <AppLayout>
      <Head title="Usuarios" />
      <div className="p-6 space-y-4">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-semibold">Usuarios</h1>
          {hasAnyRole(auth, ['admin', 'root']) && (
            <Link href="/users/create" className="text-blue-600 hover:underline">
              Crear
            </Link>
          )}
        </div>
        <div className="divide-y rounded border">
          {users.map((u) => (
            <div key={u.id} className="flex items-center justify-between p-3">
              <div>
                <div className="font-medium">{u.name}</div>
                <div className="text-sm text-gray-500">{u.email}</div>
              </div>
              <div className="flex items-center gap-3">
                <Link href={`/users/${u.id}`} className="text-blue-600 hover:underline">
                  Ver
                </Link>
                {(hasAnyRole(auth, ['admin', 'root']) || auth.user?.id === u.id) && (
                  <Link href={`/users/${u.id}/edit`} className="text-blue-600 hover:underline">
                    Editar
                  </Link>
                )}
              </div>
            </div>
          ))}
          {users.length === 0 && <div className="p-3 text-gray-500">No hay usuarios</div>}
        </div>
      </div>
    </AppLayout>
  )
}
