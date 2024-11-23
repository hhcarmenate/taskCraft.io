import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { TASKCRAFT_API } from '@/services/axios.js'

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
  encrypted: false,
  authorizer: (channel) => {
    return {
      authorize: (socketId, callback) => {
        TASKCRAFT_API.post('api/broadcasting/auth', {
          socket_id: socketId,
          channel_name: channel.name
        },
          {
            baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
          }
        )
          .then(response => {
            callback(false, response.data)
          })
          .catch(error => {
            callback(true, error)
          })
      }
    }
  }
})
