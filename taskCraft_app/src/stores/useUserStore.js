import { defineStore, getActivePinia } from 'pinia'
import UserService from '@/services/UserService.js'
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

export const useUserStore = defineStore('user', {
  state: () => ({
    isAuthenticated: false,
    name: '',
    email: '',
    userId: '',
    loadingData: false
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

    async loadAppData() {
      try {
        this.loadingData = true
        const userProfile = useUserProfileStore()
        const workspace = useWorkspaceStore()

        await userProfile.fetchUserProfile(this.userId)
        await workspace.fetchUserWorkspaces(this.userId)
      } catch (e) {
        console.error(e)
      } finally {
        this.loadingData = false
      }

    },
  },
  getters: {

  }
})
