import { TASKCRAFT_API } from './axios.js'

class ListService {
  async createBoardList({ title, boardId }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`board/${boardId}/create-list`, {
        title,
      })
    })
  }

}

export default new ListService()
