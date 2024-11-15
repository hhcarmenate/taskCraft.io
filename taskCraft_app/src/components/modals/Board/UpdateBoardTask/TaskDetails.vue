<script setup>
import {ref} from "vue"
import PrioritySelect from '@/components/modals/Board/UpdateBoardTask/PrioritySelect.vue'

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

const newPriority = ref(props.task.priority)

</script>

<template>
  <div class="p-4 border-l border-solid border-secondary-600">
    <div class="details-container">
      <h3 class="text-xl font-thin">Details</h3>
      <div class="details-container mt-3">
        <div class="priority-container flex flex-row justify-between items-center my-2">
          <div class="font-semibold">Priority</div>
          <PrioritySelect :priority="newPriority" />
        </div>
        <div class="assignee-container flex flex-row justify-between my-2">
          <div class="font-semibold">Assignee</div>
          <div class="priority-value">{{ task.assigned_to ?? 'Unassigned' }}</div>
        </div>

        <div class="reporter-container flex flex-row justify-between my-2">
          <div class="font-semibold">Reporter</div>
          <div class="priority-value">{{ task.created_by?.name ?? 'No Reporter' }}</div>
        </div>

        <div class="reporter-container flex flex-row justify-between mt-12">
          <div class="font-semibold">Start Date</div>
          <div class="priority-value">{{ task.start_date ?? 'Set Start Date' }}</div>
        </div>
        <div class="reporter-container flex flex-row justify-between my-2">
          <div class="font-semibold">Due Date</div>
          <div class="priority-value">{{ task.due_date ?? 'Set Due Date' }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
