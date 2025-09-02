import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import { hasPermission } from '@/lib/permissions'
import type { Auth } from '@/types'
import { routes } from '@/lib/routes'
import { Head, Link, usePage } from '@inertiajs/react'

type UserItem = { id: number; name: string; email: string }

type PageProps = {
  auth: Auth
  user: UserItem
  flash?: { success?: string; error?: string }
}

export default function UsersShow({ user }: { user: UserItem }) {
  const { auth, flash } = usePage<PageProps>().props

  return (
    <AppLayout>
      <Head title={`Usuario ${user.name}`} />
      <div className="p-6 space-y-4">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-semibold">{user.name}</h1>
          <div className="flex gap-3">
            {(hasPermission(auth, 'users.update') || hasAnyRole(auth, ['admin', 'root']) || auth.user?.id === user.id) && (
              <Link href={routes.users.edit(user.id)} className="text-blue-600 hover:underline">
                Editar
              </Link>
            )}
            {(hasPermission(auth, 'users.delete') || hasAnyRole(auth, ['admin', 'root'])) && (
              <Link
                as="button"
                method="delete"
                href={routes.users.delete(user.id)}
                className="text-red-600 hover:underline"
              >
                Eliminar
              </Link>
            )}
          </div>
        </div>
        {/* Toasts globales mostrarán flash; se elimina banner local */}

        <div className="rounded border p-4">
          <div className="text-sm text-gray-500">ID</div>
          <div className="mb-3 font-medium">{user.id}</div>
          <div className="text-sm text-gray-500">Email</div>
          <div className="font-medium">{user.email}</div>
        </div>
      </div>
    </AppLayout>
  )
}
