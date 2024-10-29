import {defineStore} from "pinia";
import WorkspaceService from "@/services/WorkspaceService.js";

export const useWorkspace = defineStore('workspace', {
  state: () => ({
    workspaces: [],
    workspaceSelected: null
  }),
  actions: {
    async createWorkspace({ name, type, description }) {
      return await WorkspaceService.createWorkspace({
        name,
        type,
        description
      })
    },

    async getOrCreateInvitationLink(){
      return await WorkspaceService.getOrCreateInvitationLink(this.workspaceSelected.id)
    }
  }
})
