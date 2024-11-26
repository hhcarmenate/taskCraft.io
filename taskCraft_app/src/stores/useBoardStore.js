import {defineStore} from "pinia"
import BoardService from "@/services/BoardService.js"
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js"
import ListService from "@/services/ListService.js"

export const useBoardStore = defineStore('board', {
  state: () => ({
    id: '',
    title: '',
    workspace_id: '',
    visibility: '',
    starred: false,
    lists: [],
    selectedTask: null
  }),
  actions: {
    async createBoard({ title, workspaceSelected, visibility}){
      return await BoardService.createBoard({ title, workspaceSelected, visibility })
    },

    async updateBoard({ title, workspaceSelected, visibility}) {
      return await BoardService.updateBoard({
        title,
        workspaceSelected,
        visibility,
        boardId: this.id
      })
    },

    updateBoardFromBroadcast(event) {
      const { board } = event
      this.initCurrentBoard(board)
    },

    async toggleStarred(boardId, starred) {
      return await BoardService.toggleStarred(boardId, starred)
    },

    initCurrentBoard(board) {
      this.id = board.id
      this.title = board.title
      this.workspace_id = board.workspace_id
      this.visibility = board.visibility
      this.starred = board.starred
      this.lists = board.lists

      if (this.selectedTask) {
        let taskFound = null

        board.lists.forEach((list) => {
          // Find the task in the current list
          const task = list.tasks.find(task => task.id === this.selectedTask.id)

          if (task) {
            taskFound = task
          }
        })

        if (taskFound) {
          this.selectedTask = taskFound
        }
      }
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

    updateTaskStore(taskId, newTask) {
      this.selectedTask = newTask
      this.lists.some((list) => {
        const taskIndex = list.tasks.findIndex(task => task.id === taskId)
        if (taskIndex !== -1) {
          list.tasks[taskIndex] = { ...list.tasks[taskIndex], ...newTask }
          return true
        }
        return false
      })
    },

    async updateDate({attribute, value}) {
      return await ListService.updateDate({
        taskId: this.selectedTask.id,
        attribute,
        value
      })
    },

    async createTaskChecklist(title) {
      return await ListService.createTaskChecklist({title, taskId: this.selectedTask.id})
    },

    async addChecklistItem(fields) {
      return await ListService.addCheckListItem({
        description: fields.description,
        checklistId: this.selectedTask.checklist.id
      })
    },

    addChecklistItemStore(checklistItem) {
      this.selectedTask.checklist.checklist_items.push(checklistItem)
    },

    async updateChecklistItemCompleted({itemId, attribute, value}) {
      return await ListService.updateTaskChecklistItemCompleted({itemId, attribute, value})
    },

    async addComment(comment) {
      console.log('in board', comment, this.selectedTask.id)
      return await ListService.addTaskComment({
        comment,
        taskId: this.selectedTask.id
      })
    }
  },

  getters: {

  }
})
