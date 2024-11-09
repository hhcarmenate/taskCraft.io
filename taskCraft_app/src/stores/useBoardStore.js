import {defineStore} from "pinia";
import BoardService from "@/services/BoardService.js";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

export const useBoardStore = defineStore('board', {
  state: () => ({
    id: '',
    title: '',
    workspace: '',
    visibility: '',
    starred: false
  }),
  actions: {
    async createBoard({ title, workspaceSelected, visibility}){
      return await BoardService.createBoard({ title, workspaceSelected, visibility })
    },

    async toggleStarred(boardId, starred) {
      return await BoardService.toggleStarred(boardId, starred)
    },

    initCurrentBoard(board) {
      this.id = board.id
      this.title = board.title
      this.workspace = board.workspace
      this.visibility = board.visibility
      this.starred = board.starred
    },

    initCurrentBoardFromWorkspace(boardId) {
      const workspace = useWorkspaceStore()

      this.initCurrentBoard(workspace.currentWorkspace.boards.find((board) => board.id === boardId))
    }
  },
  getters: {

  }
})
