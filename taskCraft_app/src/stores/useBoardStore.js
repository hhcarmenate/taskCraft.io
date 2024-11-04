import {defineStore} from "pinia";
import BoardService from "@/services/BoardService.js";

export const useBoardStore = defineStore('board', {
  state: () => ({
    title: '',
    workspaceId: '',
    visibility: '',
    starred: false
  }),
  actions: {
    async createBoard({ title, workspaceSelected, visibility}){
      return await BoardService.createBoard({ title, workspaceSelected, visibility })
    }
  },
  getters: {

  }
})
