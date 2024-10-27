import {defineStore} from "pinia";

export const useOverlay = defineStore('overlay', {
  state: () => ({
    isVisible: false
  }),
  actions: {
    showOverlay() {
      this.isVisible = true
    },

    hideOverlay() {
      this.isVisible = false
    }
  }
})
