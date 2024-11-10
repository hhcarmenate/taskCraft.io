import {defineStore} from "pinia";
import BoardService from "@/services/BoardService.js";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import ListService from "@/services/ListService.js";

export const useBoardStore = defineStore('board', {
  state: () => ({
    id: '',
    title: '',
    workspace: '',
    visibility: '',
    starred: false,
    lists: []
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
      this.lists = board.lists
    },

    initCurrentBoardFromWorkspace(boardId) {
      const workspace = useWorkspaceStore()

      if (workspace.currentWorkspace) {
        const selectedBoard = workspace.currentWorkspace.boards.find((board) => {
          return board.id === parseInt(boardId)
        })

        this.initCurrentBoard(selectedBoard)
      }
    },

    async createList({title}) {
      return await ListService.createBoardList({title, boardId: this.id})
    },

    async updateListsPositions(positions) {
      if (this.id) {
        return await ListService.updateListPositions({positions, boardId: this.id})
      }
    }
  },
  getters: {

  }
})
