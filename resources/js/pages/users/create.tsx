import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import React from 'react'

type PageProps = {
  auth: { user: { id: number } | null; roles: string[] }
}

export default function UsersCreate() {
  const { auth } = usePage<PageProps>().props
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    password: '',
  })

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    post('/users')
  }

  return (
    <AppLayout>
      <Head title="Crear usuario" />
      <div className="p-6 space-y-6">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-semibold">Crear usuario</h1>
          <Link href="/users" className="text-blue-600 hover:underline">Volver</Link>
        </div>

        {!hasAnyRole(auth, ['admin','root']) && (
          <div className="rounded border border-amber-400 bg-amber-50 p-3 text-amber-700">
            No tienes permisos para crear usuarios (la Policy lo bloqueará si intentas enviar el formulario).
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
            <label className="block text-sm font-medium">Password</label>
            <input
              type="password"
              className="mt-1 w-full rounded border p-2"
              value={data.password}
              onChange={(e) => setData('password', e.target.value)}
            />
            {errors.password && <div className="mt-1 text-sm text-red-600">{errors.password}</div>}
          </div>
          <button disabled={processing} className="rounded bg-blue-600 px-4 py-2 text-white disabled:opacity-50">
            Guardar
          </button>
        </form>
      </div>
    </AppLayout>
  )
}
