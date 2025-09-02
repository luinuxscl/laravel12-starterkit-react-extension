import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import type { Auth } from '@/types'
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
            {(hasAnyRole(auth, ['admin', 'root']) || auth.user?.id === user.id) && (
              <Link href={`/users/${user.id}/edit`} className="text-blue-600 hover:underline">
                Editar
              </Link>
            )}
            {hasAnyRole(auth, ['admin', 'root']) && (
              <Link
                as="button"
                method="delete"
                href={`/users/${user.id}`}
                className="text-red-600 hover:underline"
              >
                Eliminar
              </Link>
            )}
          </div>
        </div>
        {flash?.success && (
          <div className="rounded border border-green-300 bg-green-50 px-3 py-2 text-sm text-green-800 dark:border-green-800 dark:bg-green-950/30 dark:text-green-300">
            {flash.success}
          </div>
        )}

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
