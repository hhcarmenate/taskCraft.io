import axios from 'axios'
import { useMaintenanceStore } from '@/stores/useMaintenanceStore.js'
import router from '@/router'

const TASKCRAFT_API = axios.create({
  baseURL: import.meta.env.VITE_APP_TASKCRAFT_API + 'api/v1/',
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    Accept: 'application/json'
  }
})

TASKCRAFT_API.interceptors.request.use(
  (request) => request,
  (error) => error
)

TASKCRAFT_API.interceptors.response.use(
  (response) => {
    const maintenance = useMaintenanceStore()
    if (response.headers['x-maintenance-mode'] === 'true') {
      maintenance.turnOnMaintenance()
    } else {
      maintenance.turnOffMaintenance()
    }

    return response
  },
  async (error) => {
    const maintenance = useMaintenanceStore()
    if (error.response && [419, 401, 503].includes(error.response.status)) {
      if (error.response.status === 503) {
        maintenance.turnOnMaintenance()
        return await router.push({ name: 'maintenance' })
      }

      return await router.push({ name: 'Logout' })
    }

    return { error }
  }
)

export { TASKCRAFT_API }
