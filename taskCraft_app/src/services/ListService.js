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

  async updateTasksList({ tasks, listId }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`list/${listId}/update-task-list`, {
        tasks,
      })
    })
  }

  async updateTasksTitle({taskId, newTitle} ) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task/${taskId}/update-task-title`, {
        newTitle,
      })
    })
  }

  async updateTaskDescription({taskId, taskDescription}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task/${taskId}/update-task-description`, {
        taskDescription,
      })
    })
  }

  async updateTaskPriority({taskId, taskPriority}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task/${taskId}/update-task-priority`, {
        taskPriority,
      })
    })
  }

  async updateTaskAssignTo({taskId, userId}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task/${taskId}/update-task-assign`, {
        userId,
      })
    })
  }

  async updateDate({ taskId, attribute, value }) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task/${taskId}/update-task-date`, {
        attribute,
        value
      })
    })
  }

  async createTaskChecklist({title, taskId}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`task-checklist/${taskId}`, {
        title,
      })
    })

  }

  async addCheckListItem({ description, checklistId}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`task-checklist-item/${checklistId}`, {
        description,
      })
    })
  }

  async updateTaskChecklistItemCompleted({itemId, attribute, value}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.patch(`task-checklist-item/${itemId}`, {
        attribute,
        value
      })
    })
  }

  async addTaskComment({taskId, comment}) {
    return await TASKCRAFT_API.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_APP_TASKCRAFT_API
    }).then(async () => {
      return await TASKCRAFT_API.post(`task/${taskId}/comment`, {
        comment,
      })
    })
  }

  async loadTaskLogs(taskId) {
    return await TASKCRAFT_API.get(`task/${taskId}/logs`)
  }

}

export default new ListService()
