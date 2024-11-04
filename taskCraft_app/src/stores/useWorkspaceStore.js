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

    async updateWorkspace({ name, type, description }) {
      return await WorkspaceService.updateWorkspace({
        name,
        type,
        description,
        workspaceId: this.currentWorkspace.id
      })
    },

    async getOrCreateInvitationLink(){
      return await WorkspaceService.getOrCreateInvitationLink(this.currentWorkspace.id)
    },

    async sendInvitation({ invitationList, invitationText }) {
      return await WorkspaceService.sendInvitation(this.currentWorkspace.id, invitationList, invitationText)
    },

    async updateWorkSpaceLogo({ file }) {
      return await WorkspaceService.updateWorkspaceLogo(this.currentWorkspace.id, file)
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
      if (this.currentWorkspace) {
        this.currentWorkspace = this.workspaces.find((work) => work.id === this.currentWorkspace.id)
      }

    },

    initCurrentWorkspace(name) {
      console.log(name, this.workspaces)
      this.currentWorkspace = this.workspaces.find((workspace) => {
        return workspace.name === name
      })
    }
  }
})
