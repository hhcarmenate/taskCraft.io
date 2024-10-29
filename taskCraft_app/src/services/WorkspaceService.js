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

  async getOrCreateInvitationLink(workspaceId){
    return await TASKCRAFT_API.get(`workspace/${workspaceId}/invitation`)
  }

  async sendInvitation(workspaceId, invitationList, invitationText) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`workspace/${workspaceId}/send-invitation`, {
        invitationList,
        invitationText
      })
    })
  }

}

export default new WorkspaceService()
