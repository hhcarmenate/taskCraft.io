import { TASKCRAFT_API } from './axios.js'

class WorkspaceService {
  async createWorkspace({ name, type, description }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`user/createWorkspace`, {
        name,
        type,
        description,
      })
    })
  }

}

export default new WorkspaceService()
