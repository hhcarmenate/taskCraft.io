<script setup>
import { computed, ref, watch } from 'vue'
import useNotification from '@/composables/useNotification.js'
import { useBoardStore } from '@/stores/useBoardStore.js'
import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'

// Properties
const editingTask = ref()
const assignTo = ref()
const workspace = useWorkspaceStore()
const board = useBoardStore()
const {notify} = useNotification()

const assignedTo = computed(() => {
  if (!board.selectedTask?.assigned_to) {
    return 'Unassigned'
  }

  return board.selectedTask?.assigned_to?.name
})

const workspaceMembers = computed(() => {
  return workspace.getCurrentWorkspaceMembers.map(member => {
    return {
      value: member.userId,
      text: member.name
    }
  })
})


const handleEditTask = () => {
  editingTask.value = true
}

const handleFieldBlur = () => {
  editingTask.value = false
}

const updateAssignTo = async (userId) => {
  try {
    const response = await board.updateTaskAssignTo({
      taskId: board.selectedTask?.id,
      userId: userId
    })

    if (response.status === 200) {
      board.updateTaskStore(board.selectedTask?.id, response.data?.data)

      notify('success', 'Task assigned successfully!')
      editingTask.value = false
      return
    }

    notify('error', 'Oops something went wrong!')
  } catch (e) {
    console.error(e)

    notify('error', 'Oops something went wrong!')
  }
}


watch(assignTo, (newValue) => {
  if (newValue) {
    updateAssignTo(newValue)
  }
})


</script>

<template>
  <div class="priority-value">
    <span
      class="cursor-pointer"
      v-if="!editingTask"
      @click="handleEditTask"
    >
      {{ assignedTo }}
    </span>
    <span v-else>
      <select
        class="bg-gray-50 input-control mt-1 border border-gray-300 text-gray-900
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block
            w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
            dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
        v-model="assignTo"
        @blur="handleFieldBlur"
      >
        <option
          v-for="item in workspaceMembers"
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
