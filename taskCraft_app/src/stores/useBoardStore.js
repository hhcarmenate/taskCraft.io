import {defineStore} from "pinia"
import BoardService from "@/services/BoardService.js"
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js"
import ListService from "@/services/ListService.js"

export const useBoardStore = defineStore('board', {
  state: () => ({
    id: '',
    title: '',
    workspace: '',
    visibility: '',
    starred: false,
    lists: [],
    selectedTask: null
  }),
  actions: {
    async createBoard({ title, workspaceSelected, visibility}){
      return await BoardService.createBoard({ title, workspaceSelected, visibility })
    },

    async toggleStarred(boardId, starred) {
      return await BoardService.toggleStarred(boardId, starred)
    },

    initCurrentBoard(board) {
      this.id = board.id
      this.title = board.title
      this.workspace = board.workspace
      this.visibility = board.visibility
      this.starred = board.starred
      this.lists = board.lists
    },

    initCurrentBoardFromWorkspace(boardId) {
      const workspace = useWorkspaceStore()

      if (workspace.currentWorkspace) {
        const selectedBoard = workspace.currentWorkspace.boards.find((board) => {
          return board.id === parseInt(boardId)
        })

        this.initCurrentBoard(selectedBoard)
      }
    },

    async createList({title}) {
      return await ListService.createBoardList({title, boardId: this.id})
    },

    async updateListsPositions(positions) {
      if (this.id) {
        return await ListService.updateListPositions({positions, boardId: this.id})
      }
    },

    async updateListName({ listId, newListTitle }) {
      return await ListService.updateTitle({ listId, newListTitle })
    },

    async addTaskToBoardList({ boardListId, taskTitle }) {
      return await ListService.createTask({ boardListId, taskTitle })
    },

    async updateLists({tasks, listId}) {
      return await ListService.updateTasksList({tasks, listId} )
    },

    async updateTaskTitle({taskId, newTitle}) {
      return await ListService.updateTasksTitle({taskId, newTitle})
    },

    async updateTaskDescription({taskId, taskDescription }) {
      return await ListService.updateTaskDescription({taskId, taskDescription})
    },

    async updateTaskPriority({taskId, taskPriority}) {
      return await ListService.updateTaskPriority({taskId, taskPriority})
    },

    updateTaskPriorityStore(taskId, priority) {
      this.lists.forEach((list) => {
        const currentTask = list.tasks.find(task => task.id === taskId)

        if (currentTask) {
          currentTask.priority = priority
        }
      })
    },

    async updateTaskAssignTo({ taskId, userId}) {
      return await ListService.updateTaskAssignTo({taskId, userId})
    },

    updateTaskAssignToStore(taskId, newTask) {
      console.log(taskId, newTask)
      this.lists.some((list) => {
        const taskIndex = list.tasks.findIndex(task => task.id === taskId)
        if (taskIndex !== -1) {
          list.tasks[taskIndex] = { ...list.tasks[taskIndex], ...newTask }
          return true
        }
        return false
      })
    },

  },

  getters: {

  }
})
