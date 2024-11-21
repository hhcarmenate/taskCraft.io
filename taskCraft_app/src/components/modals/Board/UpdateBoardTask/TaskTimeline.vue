<script setup>
import { ref } from 'vue'
import useNotification from '@/composables/useNotification.js'
import ListService from '@/services/ListService.js'
import { useBoardStore } from '@/stores/useBoardStore.js'

// Data
const showingTimeline = ref(false)
const loadingTaskLogs = ref(false)
const taskLogs = ref([])
const {notify} = useNotification()
const board = useBoardStore()

// Methods
const toggleViewActivity = async () => {
  showingTimeline.value = !showingTimeline.value

  if (showingTimeline.value) {
    try {
      loadingTaskLogs.value = true

      const response = await ListService.loadTaskLogs(board.selectedTask.id)

      if (response.status === 200) {
        taskLogs.value = response.data
      } else {
        notify('error', 'Oops something went wrong!')
      }
    } catch (e) {
      console.log(e)

      notify('error', 'Oops something went wrong!')
    } finally {
      loadingTaskLogs.value = false
    }
  }
}

</script>

<template>
  <div class="activity-container mt-5 ">
    <div class="activity-header flex flex-row justify-between items-center">
      <h3 class="text-xl font-thin">Activity</h3>

      <a
        @click="toggleViewActivity"
        class="cursor-pointer"
      >
        <span
          v-if="showingTimeline"
          class="line-through"
        >
          Hide
        </span>
        <span v-else>
          Show
        </span>
      </a>
    </div>


    <div
      class="timeline mt-5"
      v-if="showingTimeline"
    >
      <ol class="relative border-l border-gray-200 dark:border-gray-700">
        <li
          v-for="activity in taskLogs"
          :key="activity.id"
          class="mb-10 ml-6"
        >
          <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-4 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
            <svg
              aria-hidden="true"
              class="w-4 h-4 text-blue-500 dark:text-blue-400"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-11.41a1 1 0 00-1.14-.7 6 6 0 11-6.3 6.55 1 1 0 10-2-.35A8 8 0 1013 6.59z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
          <div
            class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-600"
          >
            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">
              {{ activity.action }}
            </h3>
            <time
              v-if="activity.date"
              class="text-sm font-normal leading-none text-gray-500 dark:text-gray-500"
            >
              {{ activity.date }}
            </time>
          </div>
        </li>
      </ol>
    </div>

    
  </div>
</template>

<style scoped>

</style>
