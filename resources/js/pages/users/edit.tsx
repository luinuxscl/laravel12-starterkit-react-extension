import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import React from 'react'

type UserItem = { id: number; name: string; email: string }

type PageProps = {
  auth: { user: { id: number } | null; roles: string[] }
  user: UserItem
}

export default function UsersEdit({ user }: { user: UserItem }) {
  const { auth } = usePage<PageProps>().props
  const { data, setData, patch, processing, errors } = useForm({
    name: user.name,
    email: user.email,
    password: '',
  })

  const canEdit = hasAnyRole(auth, ['admin', 'root']) || auth.user?.id === user.id

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    patch(`/users/${user.id}`)
  }

  return (
    <AppLayout>
      <Head title={`Editar ${user.name}`} />
      <div className="p-6 space-y-6">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-semibold">Editar usuario</h1>
          <Link href={`/users/${user.id}`} className="text-blue-600 hover:underline">
            Volver
          </Link>
        </div>

        {!canEdit && (
          <div className="rounded border border-amber-400 bg-amber-50 p-3 text-amber-700">
            No tienes permisos para editar este usuario (la Policy lo bloqueará si intentas enviar el formulario).
          </div>
        )}

        <form onSubmit={onSubmit} className="space-y-4 max-w-lg">
          <div>
            <label className="block text-sm font-medium">Nombre</label>
            <input
              className="mt-1 w-full rounded border p-2"
              value={data.name}
              onChange={(e) => setData('name', e.target.value)}
            />
            {errors.name && <div className="mt-1 text-sm text-red-600">{errors.name}</div>}
          </div>
          <div>
            <label className="block text-sm font-medium">Email</label>
            <input
              type="email"
              className="mt-1 w-full rounded border p-2"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
            />
            {errors.email && <div className="mt-1 text-sm text-red-600">{errors.email}</div>}
          </div>
          <div>
            <label className="block text-sm font-medium">Password (opcional)</label>
            <input
              type="password"
              className="mt-1 w-full rounded border p-2"
              value={data.password}
              onChange={(e) => setData('password', e.target.value)}
            />
            {errors.password && <div className="mt-1 text-sm text-red-600">{errors.password}</div>}
          </div>
          <button disabled={processing} className="rounded bg-blue-600 px-4 py-2 text-white disabled:opacity-50">
            Guardar cambios
          </button>
        </form>
      </div>
    </AppLayout>
  )
}
