import { defineStore, getActivePinia } from 'pinia'
import UserService from '@/services/UserService.js'

export const useUserStore = defineStore('user', {
  state: () => ({
    isAuthenticated: false,
    name: '',
    email: '',
    userId: ''
  }),
  persist: true,
  actions: {
    async login({ email, password }) {
      const response = await UserService.login({ email, password })

      if (response.status === 200) {
        const { data } = response.data
        if (data) {
          this.name = data.name
          this.email = data.email
          this.userId = data.userId
          this.isAuthenticated = true
        }
      }

      return response
    },

    async logOut() {
      getActivePinia()._s.forEach((store) => store.$reset())
    },

    async register({ name, email, password }) {
      return await UserService.register({ name, email, password })
    },

    async confirmRegistration(confirmationUrl) {
      return await UserService.confirmRegistrationEmail(confirmationUrl)
    },

    async forgotPassword({ email }) {
      return await UserService.forgotPassword(email)
    },

    async resetPassword({ password, url }) {
      return await UserService.resetPassword({ password, url })
    },

    async loadUserData() {
      const response = await UserService.getUserData(this.uuid)

      if (response.status === 200) {
        const result = response.data

      } else {
        // show Error page...
      }
    },
  },
  getters: {

  }
})
