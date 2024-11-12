import {defineStore} from "pinia";
import WorkspaceService from "@/services/WorkspaceService.js";
import BoardService from "@/services/BoardService.js";

export const useWorkspaceStore = defineStore('workspace', {
  state: () => ({
    workspaces: [],
    currentWorkspace: null,
    recentBoards: []
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

        const [workspaceResponse, recentBoardResponse] = await Promise.all([
          WorkspaceService.getUserWorkspaces(userId),
          BoardService.getRecentBoards()
        ])

        if (workspaceResponse.data) {
          const { data } = workspaceResponse.data
          this.initWorkspaces(data)
        }

        if (recentBoardResponse.data) {
          const { data } = recentBoardResponse.data
          this.recentBoards = data
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
      this.currentWorkspace = this.workspaces.find((workspace) => {
        return workspace.name === name
      })
    },

    async getJoinData(token) {
      return await WorkspaceService.getJoinData(token)
    },

    async registerAndJoin({name, email, password, workspace}) {
      return await WorkspaceService.registerAndJoin({name, email, password, workspace})
    },

    async saveRecentBoard(boardId){
      const response = await BoardService.saveRecentBoard(boardId)

      if (response.status >= 200 && response.status < 300) {
        const { data } = response.data
        this.recentBoards.unshift(data)
        this.recentBoards = this.recentBoards.slice(0, 5)
      }
    }
  },

  getters: {
    starredBoard() {
      let userStarredBoards = []

      this.workspaces.forEach((workspace) => {
        if (workspace.boards) {
          workspace.boards.forEach((board) => {
            if (board.starred === true) {
              userStarredBoards.push(board)
            }
          })
        }
      })

      return userStarredBoards
    }
  }
})
