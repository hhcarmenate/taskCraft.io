import {defineStore} from "pinia";
import BoardService from "@/services/BoardService.js";

export const useBoardStore = defineStore('board', {
  state: () => ({
    title: '',
    workspace: '',
    visibility: '',
    starred: false
  }),
  actions: {
    async createBoard({ title, workspaceSelected, visibility}){
      return await BoardService.createBoard({ title, workspaceSelected, visibility })
    },

    async toggleStarred(boardId) {
      return await BoardService.toggleStarred(boardId)
    }
  },
  getters: {

  }
})
