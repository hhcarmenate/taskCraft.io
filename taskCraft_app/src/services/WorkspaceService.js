import { TASKCRAFT_API } from './axios.js'

class WorkspaceService {
  async createWorkspace({ name, type, description }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`user/create-workspace`, {
        name,
        type,
        description,
      })
    })
  }

  async updateWorkspace({ name, type, description, workspaceId }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.put(`workspace/${workspaceId}/update-workspace`, {
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

  async updateWorkspaceLogo(workspaceId, file) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      const formData = new FormData()

      formData.append('workspaceLogo', file)

      return await TASKCRAFT_API.post(`workspace/${workspaceId}/update-logo`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
    })
  }

  async getUserWorkspaces(userId) {
    return await TASKCRAFT_API.get(`user/${userId}/workspaces`)
  }

  async getJoinData(token) {
    return await TASKCRAFT_API.get(`workspace/check-invitation/${token}`)
  }

  async registerAndJoin({name, email, password, workspace}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`workspace/register-join`, {
        name,
        email,
        password,
        workspace_id: workspace
      })
    })
  }

}

export default new WorkspaceService()
