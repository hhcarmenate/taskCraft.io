import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.pusher = Pusher

window.Echo = new Echo({
  broadcaster: 'reverb',
  key: import.meta.env.VITE_REVERB_APP_KEY,
  wsHost: 'dev.reverb.taskcraft.com',
  wsPort: 8080,
  wssHost: 'dev.reverb.taskcraft.com',
  wssPort: 8080,
  forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
  enabledTransports: ['ws', 'wss'],
  disableStats: true,
  encrypted: false
})
