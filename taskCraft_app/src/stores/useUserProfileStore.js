import { defineStore } from 'pinia'
import UserService from '@/services/UserService.js'

export const useUserProfileStore = defineStore('userProfile', {
  state: () => ({
    id: null,
    userId: null,
    birthDate: null,
    language: 'EN',
    phoneNumber: null,
    profilePicture: null,
    uiMode: 'dark',
    bio: null,
    timezone: null,
    notificationPreferences: null,
    jobPosition: null
  }),
  persist: true,
  actions: {

    initUserPreferences(data) {
      Object.assign(this, data.data)
    },

    async fetchUserProfile(userId) {
      try {
        const response = await UserService.getUserProfile(userId)
        if (response.data) {
          const data = response.data

          this.initUserPreferences(data)
        }
      } catch (error) {
        console.error('Failed to fetch user profile:', error)
      }
    },

    async updateMainUserProfile({ name, jobPosition, file }){
      return await UserService.updateMainUserProfile({name, jobPosition, file, userId: this.userId})
    },

    async updateGeneralInfoProfile({ bio, uiMode, language, timezone }){
      return await UserService.updateGeneralInfoProfile({
        bio,
        uiMode,
        language,
        timezone,
        userId: this.userId
      })
    }
  },
  getters: {

  }
})
