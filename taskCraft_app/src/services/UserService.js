import { TASKCRAFT_API } from './axios.js'

class UserService {
  async login({ email, password }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post('login', {
        email,
        password,
      })
    })
  }

  async register({ name, email, password }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(
      async () =>
        await TASKCRAFT_API.post('register', {
          name,
          email,
          password,
        })
    )
  }

  async confirmRegistrationEmail(confirmationUrl) {
    return await TASKCRAFT_API.get(confirmationUrl)
  }

  async forgotPassword(email) {
    return await TASKCRAFT_API.get(`user/forgot-password/${email}`)
  }

  async resetPassword({ password, url }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(url, { password })
    })
  }

  async getUserProfile(userId) {
    return await TASKCRAFT_API.get(`user/${userId}/profile`)
  }

  async updateUserProfile(formData, uuid) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`user/${uuid}/update-profile`, formData)
    })
  }

  async updateMainUserProfile({ name, jobPosition, file, userId }){
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      const formData = new FormData()

      formData.append('profilePicture', file)
      formData.append('name', name)
      formData.append('jobPosition',jobPosition )

      return await TASKCRAFT_API.post(`user/${userId}/update-main-profile`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
    })
  }

  async updateGeneralInfoProfile({ bio, uiMode, language, timezone, userId }){
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`user/${userId}/update-general-info-profile`, {
        bio,
        uiMode,
        language,
        timezone
      })
    })
  }
}

export default new UserService()
