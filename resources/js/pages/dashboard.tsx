import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type Auth, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard() {
    const { auth } = usePage<{ auth: Auth }>().props;
    const roles = auth?.roles ?? [];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                </div>
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>

                {/* Roles actuales */}
                <div className="rounded-md border border-sidebar-border/70 p-4 text-sm dark:border-sidebar-border">
                    <div className="mb-2 font-medium">Tus roles</div>
                    {roles.length > 0 ? (
                        <div className="flex flex-wrap gap-2">
                            {roles.map((r) => (
                                <span
                                    key={r}
                                    className="inline-flex items-center rounded-md border px-2 py-1 text-xs font-medium text-foreground/90 border-sidebar-border/70 dark:border-sidebar-border"
                                >
                                    {r}
                                </span>
                            ))}
                        </div>
                    ) : (
                        <div className="text-foreground/60">Sin roles asignados</div>
                    )}
                </div>

                {/* Gate simple por rol */}
                {(roles.includes('admin') || roles.includes('root')) && (
                    <div className="rounded-md border border-emerald-500/40 bg-emerald-500/5 p-4 text-sm">
                        <div className="font-medium text-emerald-600 dark:text-emerald-400">Sección visible solo para admin/root</div>
                        <p className="mt-1 text-foreground/70">
                            Este bloque se renderiza cuando el usuario tiene el rol <code>admin</code> o <code>root</code>.
                        </p>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
