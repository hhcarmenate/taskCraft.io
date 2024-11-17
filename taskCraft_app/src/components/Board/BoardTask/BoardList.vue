<script setup>
import draggable from "vuedraggable"
import AddBoardTask from "@/components/Board/BoardTask/AddBoardTask.vue"
import { ref, useAttrs } from 'vue'
import BoardListTask from "@/components/Board/BoardTask/BoardListTask.vue"
import BoardListTitleComponent from "@/components/Board/BoardTask/BoardListTitleComponent.vue"
import {useBoardStore} from "@/stores/useBoardStore.js"
import useNotification from "@/composables/useNotification.js"
import UpdateBoardTaskModal from "@/components/modals/Board/UpdateBoardTaskModal.vue"

// Emits ands Props
const emit = defineEmits(['add:task'])
const props = defineProps({
  listElement: {
    type: Object,
    required: true
  }
})

const addingTask = ref(false)
const currentElement = ref(props.listElement)
const board = useBoardStore()
const elementTasks = ref(props.listElement.tasks)
const {notify} = useNotification()
const selectedTask = ref(null)
const showEditModal = ref(false)

const attrs = useAttrs()

// Methods
const showAddTask = () => {
  addingTask.value = true
}

const handleAddNewTask = (taskTitle) => {
  emit('add:task', {id: currentElement.value.id, title: taskTitle})
  addingTask.value = false
}

const handleChange = () => {
  updateLists()
}

const updateLists = async () => {
  try {
    const tasksInOrder = elementTasks.value.map((task, index) => {
      return { id: task.id, position: index + 1 }
    })

    const response = await board.updateLists({
      listId: props.listElement.id,
      tasks: tasksInOrder
    })

    if (response.status === 200) { /* empty */ } else {
      notify('error', 'Oops something went wrong!')
    }

    } catch (e) {
      console.log(e)

      notify('error', 'Oops something went wrong')
    }
}

const handleSelectTask = (task) => {
  board.selectedTask = task
  showEditModal.value = true
}

const handleCloseModal = () => {
  board.selectedTask = null
  showEditModal.value = false
}

</script>

<template>
  <div
    :key="currentElement.id"
    v-bind="attrs"
    class="board-list bg-white shadow-md rounded p-4 w-64 flex flex-col dark:bg-gray-800"
  >
    <BoardListTitleComponent :list-element="currentElement" />
    <div class="task-content h-full flex flex-col justify-between">
      <draggable
        v-model="elementTasks"
        group="tasks"
        class="flex flex-col gap-2"
        :options="{ animation: 200 }"
        item-key="id"
        @change="handleChange"
        :ghost-class="'task-ghost'"
      >
        <template #item="{ element }">
          <BoardListTask
            :task-element="element"
            @update:task="handleSelectTask"
          />
        </template>
      </draggable>
      <AddBoardTask
        :board-list="listElement"
        v-if="addingTask"
        @update:cancel="addingTask = false"
        @update:new="handleAddNewTask"
      />
    </div>
    <button
      v-if="!addingTask"
      @click="showAddTask()"
      class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
              bg-white rounded-lg border border-gray-200 hover:bg-gray-100
              hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
              dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
              dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
    >
      Add Task
    </button>
  </div>
  <UpdateBoardTaskModal
    v-if="board.selectedTask"
    :show="showEditModal"
    :size="'extra-large'"
    @update:show="handleCloseModal"
  />
</template>

<style scoped>
.sortable-chosen {
  opacity: 0.1;
  background-color: #7e5454;
  transform: rotate(-2deg);
}

.flip-list-move {
  transform: rotate(-2deg)
}
</style>
