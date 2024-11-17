<script setup>

import { ref } from 'vue'
import { useBoardStore } from '@/stores/useBoardStore.js'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import useNotification from '@/composables/useNotification.js'

const editingStartDate = ref(false)
const board = useBoardStore()
const startDate = ref(board.selectedTask.start_date)
const { notify } = useNotification()

const handleStartDate = () => {
  editingStartDate.value = true
}

const handleBlur = async () => {
  try {
    if (startDate.value) {
      const response = await board.updateStartDate(startDate.value)

      if (response.status === 200) {
        board.updateTaskStore(board.selectedTask.id, response.data?.data)

        notify('success', 'Start Date updated successfully!')
        editingStartDate.value = false
        return
      }


      notify('error', 'Oops something went wrong!')
    }
    editingStartDate.value = false

  } catch (e) {
    console.error(e)

    notify('error', 'Oops something went wrong!')
  }
}

</script>

<template>
  <div class="priority-value">
    <span
      class="cursor-pointer"
      v-if="!editingStartDate"
      @click="handleStartDate"
    >
      {{ board.selectedTask.start_date ?? 'Set start date' }}
    </span>
    <span v-else>
      <VueDatePicker
        id="start_date"
        v-model="startDate"
        :dark="true"
        :enable-time-picker="false"
        format="MM/dd/yyyy"
        model-type="MM/dd/yyyy"
        week-start="0"
        auto-apply
        @blur="handleBlur"
      />
    </span>
  </div>
</template>

<style scoped>

</style>
