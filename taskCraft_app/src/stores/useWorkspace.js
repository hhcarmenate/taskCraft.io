import {defineStore} from "pinia";
import {useUserStore} from "@/stores/useUserStore.js";
import WorkspaceService from "@/services/WorkspaceService.js";

export const useWorkspace = defineStore('workspace', {
  state: () => ({
    workspaces: []
  }),
  actions: {
    async createWorkspace({ name, type, description }) {
      return await WorkspaceService.createWorkspace({
        name,
        type,
        description
      })
    }
  }
})
