<script setup>
import draggable from "vuedraggable";
import AddBoardTask from "@/components/Board/BoardTask/AddBoardTask.vue";
import {ref, watch} from "vue";
import BoardListTask from "@/components/Board/BoardTask/BoardListTask.vue";
import BoardListTitleComponent from "@/components/Board/BoardTask/BoardListTitleComponent.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import useNotification from "@/composables/useNotification.js";

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

// Methods
const showAddTask = () => {
  addingTask.value = true
}

const handleAddNewTask = (taskTitle) => {
  emit('add:task', {id: currentElement.value.id, title: taskTitle})
  addingTask.value = false
}

const handleMove = (data) => {
  console.log(data.draggedContext)
}

const updateLists = async (tasks) => {
  try {
    const tasksInOrder = tasks.map((task, index) => {
      return { id: task.id, position: index + 1 }
    })

    const response = await board.updateLists({
      listId: props.listElement.id,
      tasks: tasksInOrder
    })

    if (response.status === 200) {
      // todo update lists in board
    } else {
      notify('error', 'Oops something went wrong!')
    }

    } catch (e) {
      console.log(e)

      notify('error', 'Oops something went wrong')
    }
}

watch(() => elementTasks.value, (newTasks) => {
  console.log(newTasks)
  updateLists(newTasks)
}, {
  deep: true
})


</script>

<template>
      <div
        :key="currentElement.id"
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
            @move="handleMove"
          >
            <template #item="{ element }">
              <BoardListTask
                :task-element="element"
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
</template>

<style scoped>

</style>
