import { useEffect, useState } from 'react'
import { usePage } from '@inertiajs/react'

type Flash = { success?: string; error?: string }

export function FlashToaster() {
  const { flash } = usePage<{ flash?: Flash }>().props
  const [message, setMessage] = useState<Flash | null>(null)

  useEffect(() => {
    if (flash?.success || flash?.error) {
      setMessage({ success: flash.success, error: flash.error })
      const t = setTimeout(() => setMessage(null), 3200)
      return () => clearTimeout(t)
    }
  }, [flash?.success, flash?.error])

  if (!message) return null

  const isSuccess = Boolean(message.success)
  const text = message.success ?? message.error ?? ''

  return (
    <div className="pointer-events-none fixed inset-x-0 top-3 z-50 flex justify-center">
      <div
        className={
          'pointer-events-auto max-w-[90%] rounded-md px-4 py-2 text-sm shadow-lg ' +
          (isSuccess
            ? 'border border-green-300 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-950/30 dark:text-green-300'
            : 'border border-red-300 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300')
        }
        role="status"
        aria-live="polite"
      >
        {text}
      </div>
    </div>
  )
}
