import { TASKCRAFT_API } from './axios.js'

class BoardService {
  async createBoard({ title, workspaceSelected, visibility }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`board`, {
        title,
        workspaceSelected,
        visibility,
      })
    })
  }

  async updateBoard({ title, workspaceSelected, visibility, boardId }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.put(`board/${boardId}`, {
        title,
        workspaceSelected,
        visibility,
      })
    })
  }

  async toggleStarred(boardId, starred) {
    try {
      await TASKCRAFT_API.get('sanctum/csrf-cookie', { baseURL: import.meta.env.VITE_APP_TASKCRAFT_API})
      return await TASKCRAFT_API.post(`board/${boardId}/toggle-starred`, { starred })
    } catch (e) {
      console.log(e)
    }
  }

  async getRecentBoards() {
    return await TASKCRAFT_API.get('board/recent-boards')
  }

  async saveRecentBoard(boardId) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`board/recent-boards`, {
        boardId,
      })
    })
  }


}

export default new BoardService()
