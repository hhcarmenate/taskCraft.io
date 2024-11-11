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

  async updateListPositions({positions, boardId}){
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.put(`board/${boardId}/update-lists-positions`, {
        positions,
      })
    })
  }

  async updateTitle({ listId, newListTitle }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.put(`list/${listId}/update-lists-title`, {
        newListTitle,
      })
    })
  }

  async createTask({ boardListId, taskTitle }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`list/${boardListId}/create-task`, {
        taskTitle,
      })
    })
  }

}

export default new ListService()
