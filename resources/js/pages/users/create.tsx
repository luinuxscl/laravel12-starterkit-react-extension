import AppLayout from '@/layouts/app-layout'
import { hasAnyRole } from '@/lib/auth'
import type { Auth } from '@/types'
import { routes } from '@/lib/routes'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import React from 'react'

type PageProps = {
  auth: Auth
  roles?: string[]
}

export default function UsersCreate() {
  const { auth, roles = [] } = usePage<PageProps>().props
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    password: '',
    roles: [] as string[],
  })

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    post(routes.users.index())
  }

  return (
    <AppLayout>
      <Head title="Crear usuario" />
      <div className="p-6 space-y-6">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-semibold">Crear usuario</h1>
          <Link href={routes.users.index()} className="text-blue-600 hover:underline">Volver</Link>
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
          {hasAnyRole(auth, ['admin','root']) && (
            <div>
              <label className="block text-sm font-medium">Roles</label>
              <div className="mt-2 flex flex-wrap gap-3">
                {roles.map((r) => {
                  const checked = (data.roles as string[]).includes(r)
                  return (
                    <label key={r} className="inline-flex items-center gap-2 text-sm">
                      <input
                        type="checkbox"
                        className="h-4 w-4"
                        checked={checked}
                        onChange={(e) => {
                          const next = new Set(data.roles as string[])
                          if (e.target.checked) next.add(r)
                          else next.delete(r)
                          setData('roles', Array.from(next))
                        }}
                      />
                      <span className="capitalize">{r}</span>
                    </label>
                  )
                })}
              </div>
              {errors.roles && <div className="mt-1 text-sm text-red-600">{String(errors.roles)}</div>}
            </div>
          )}
          <button disabled={processing} className="rounded bg-blue-600 px-4 py-2 text-white disabled:opacity-50">
            Guardar
          </button>
        </form>
      </div>
    </AppLayout>
  )
}
