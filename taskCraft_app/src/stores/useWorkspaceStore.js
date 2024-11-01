import {defineStore} from "pinia";
import WorkspaceService from "@/services/WorkspaceService.js";

export const useWorkspaceStore = defineStore('workspace', {
  state: () => ({
    workspaces: [],
    currentWorkspace: null
  }),
  actions: {

    setCurrentWorkSpace(work) {
      this.currentWorkspace = work
    },

    async createWorkspace({ name, type, description }) {
      return await WorkspaceService.createWorkspace({
        name,
        type,
        description
      })
    },

    async getOrCreateInvitationLink(){
      return await WorkspaceService.getOrCreateInvitationLink(this.workspaceSelected.id)
    },

    async sendInvitation({ invitationList, invitationText }) {
      return await WorkspaceService.sendInvitation(this.workspaceSelected.id, invitationList, invitationText)
    },

    async fetchUserWorkspaces(userId) {
      try {
        const response = await WorkspaceService.getUserWorkspaces(userId)
        if (response.data) {
          const { data } = response.data

          this.initWorkspaces(data)
        }
      } catch (error) {
        console.error('Failed to fetch user profile:', error)
      }
    },

    initWorkspaces(data) {
      this.workspaces = data
    },

    initCurrentWorkspace(name) {
      console.log(name, this.workspaces)
      this.currentWorkspace = this.workspaces.find((workspace) => {
        console.log('here test', workspace)
        return workspace.name === name
      })
    }
  }
})
