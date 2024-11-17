<script setup>
import { computed, ref, watch } from 'vue'
import useNotification from '@/composables/useNotification.js'
import { useBoardStore } from '@/stores/useBoardStore.js'

// Constants
const TASK_PRIORITIES = [
  { value: 'low', text: 'Low' },
  { value: 'high', text: 'High' },
]

// Properties
const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

// Data
const newPriority = ref(props.task.priority)
const editingPriority = ref(false)
const { notify } = useNotification()
const board = useBoardStore()


// Computed properties
const taskPriority = computed(() => {
  if (!props.task || !props.task?.priority) return ''
  return capitalizeFirstLetter(props.task.priority)
})

// Methods
const capitalizeFirstLetter = (string) => {
  return string ? string.charAt(0).toUpperCase() + string.slice(1) : ''
}

// Handle priority edit
const handleEditPriority = () => {
  editingPriority.value = true
}

const handleFieldBlur = () => {
  editingPriority.value = false
}

const updatePriority = async (priority) => {
  try {
    const response = await board.updateTaskPriority({
      taskId: props.task.id,
      taskPriority: priority
    })

    if (response.status === 200) {
      board.updateTaskPriorityStore(props.task.id, priority)

      notify('success', 'Task priority updated successfully!')
      editingPriority.value = false
      return
    }


    notify('error', 'Oops something went wrong!')
  } catch (e) {
    console.error(e)

    notify('error', 'Oops something went wrong!')
  }
}

// Watch for priority changes and trigger form submission
watch(newPriority, (newValue) => {
  updatePriority(newValue)
})



</script>

<template>
  <div class="priority-value">
    <span
      class="cursor-pointer"
      v-if="!editingPriority"
      @click="handleEditPriority"
    >
      {{ taskPriority }}
    </span>
    <span v-else>
      <select
        class="bg-gray-50 input-control mt-1 border border-gray-300 text-gray-900
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block
            w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
            dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
        v-model="newPriority"
        @blur="handleFieldBlur"
      >
        <option
          v-for="item in TASK_PRIORITIES"
          :value="item.value"
          :key="item.value"
        >
          {{ item.text }}
        </option>
      </select>
    </span>
  </div>
</template>

<style scoped>
</style>
