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
      toast.error(text, {
        position: toast.POSITION.BOTTOM_LEFT
      })
    }

    if (type === 'warn') {
      toast.warn(text, {
        position: toast.POSITION.BOTTOM_LEFT
      })
    }

    if (type === 'info') {
      toast.info(text, {
        position: toast.POSITION.BOTTOM_LEFT
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
