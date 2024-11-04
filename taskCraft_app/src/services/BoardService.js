import { TASKCRAFT_API } from './axios.js'

class BoardService {
  async createBoard({ title, workspaceSelected, visibility }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`board/create-board`, {
        title,
        workspaceSelected,
        visibility,
      })
    })
  }

}

export default new BoardService()