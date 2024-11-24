import {defineStore} from "pinia"
import WorkspaceService from "@/services/WorkspaceService.js"
import BoardService from "@/services/BoardService.js"
import { useUserStore } from '@/stores/useUserStore.js'

export const useWorkspaceStore = defineStore('workspace', {
  state: () => ({
    workspaces: [],
    currentWorkspace: null,
    recentBoards: []
  }),
  actions: {
    updateWorkspaceFromBroadcast(event) {
      this.currentWorkspace = event.workspace
      const workspaceIndex = this.workspaces.findIndex(
        workspace => workspace.id === event.workspace.id
      )

      if (workspaceIndex !== -1) {
        this.workspaces[workspaceIndex] = event.workspace
      } else {
        this.workspaces.push(event.workspace)
      }
    },

    addNewBoardFromBroadcast(event) {
      this.workspaces.forEach((workspace) => {
        if (workspace.id === event.board.workspace_id) {
          workspace.boards.push(event.board)
        }
      })

    },

    setCurrentWorkSpace(work) {
      const user = useUserStore()
      this.currentWorkspace = work
      user.workspaceSelected = this.currentWorkspace.id
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
        this.recentBoards = data
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
    },

    getCurrentWorkspaceMembers() {
      let currentMembers = []

      currentMembers = [...this.currentWorkspace.members]
      currentMembers.push(this.currentWorkspace.owner)

      return currentMembers
    }
  }
})
