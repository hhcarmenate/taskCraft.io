<script setup>
import PrioritySelect from '@/components/modals/Board/UpdateBoardTask/PrioritySelect.vue'
import AssignTask from '@/components/modals/Board/UpdateBoardTask/AssignTask.vue'
import { useBoardStore } from '@/stores/useBoardStore.js'
import DateTask from '@/components/modals/Board/UpdateBoardTask/DateTask.vue'

const board = useBoardStore()

</script>

<template>
  <div class="p-4 border-l border-solid border-secondary-600">
    <div class="details-container">
      <h3 class="text-xl font-thin">Details</h3>
      <div class="details-container mt-3">
        <div class="priority-container flex flex-row justify-between items-center my-2">
          <div class="font-semibold">Priority</div>
          <PrioritySelect />
        </div>
        <div class="assignee-container flex flex-row justify-between items-center my-2">
          <div class="font-semibold">Assignee</div>
          <AssignTask />
        </div>

        <div class="reporter-container flex flex-row justify-between items-center my-2">
          <div class="font-semibold">Reporter</div>
          <div class="priority-value">
            {{ board.selectedTask.created_by?.name ?? 'No Reporter' }}
          </div>
        </div>

        <div class="reporter-container flex flex-row justify-between items-center mt-12">
          <div class="font-semibold">Start Date</div>
          <DateTask :attr="'start_date'" />
        </div>
        <div class="reporter-container flex flex-row justify-between items-center my-2">
          <div class="font-semibold">Due Date</div>
          <DateTask :attr="'due_date'" />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
