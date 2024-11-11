<script setup>
import draggable from "vuedraggable";
import AddBoardTask from "@/components/Board/BoardTask/AddBoardTask.vue";
import {ref} from "vue";
import BoardListTask from "@/components/Board/BoardTask/BoardListTask.vue";
import BoardListTitleComponent from "@/components/Board/BoardTask/BoardListTitleComponent.vue";

const emit = defineEmits(['add:task'])
const props = defineProps({
  listElement: {
    type: Object,
    required: true
  }
})
const addingTask = ref(false)

const showAddTask = () => {
  addingTask.value = true
}

const currentElement = ref(props.listElement)

const handleAddNewTask = (taskTitle) => {
  emit('add:task', {id: currentElement.value.id, title: taskTitle})
  addingTask.value = false
}

</script>

<template>
      <div
        :key="currentElement.id"
        class="board-list bg-white shadow-md rounded p-4 w-64 flex flex-col dark:bg-gray-800"
      >
        <BoardListTitleComponent :list-element="currentElement" />
        <div class="task-content h-full flex flex-col justify-between">
          <draggable
            v-model="currentElement.tasks"
            group="tasks"
            class="flex flex-col gap-2"
            :options="{ animation: 200 }"
            item-key="id"
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
