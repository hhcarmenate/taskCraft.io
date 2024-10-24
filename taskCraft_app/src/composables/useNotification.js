import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

export default function useNotification() {
  const notify = (type, text) => {
    if (type === 'success') {
      toast.dark(text, {
        position: toast.POSITION.BOTTOM_LEFT,
        type: 'success'
      })
    }

    if (type === 'error') {
      toast.dark(text, {
        position: toast.POSITION.BOTTOM_LEFT,
        type: 'error'
      })
    }

    if (type === 'warn') {
      toast.dark(text, {
        position: toast.POSITION.BOTTOM_LEFT,
        type: 'warn'
      })
    }

    if (type === 'info') {
      toast.dark(text, {
        position: toast.POSITION.BOTTOM_LEFT,
        type: 'info'
      })
    }

    if (type === 'default') {
      toast.dark(text, {
        position: toast.POSITION.BOTTOM_LEFT
      })
    }
  }

  return { notify }
}
