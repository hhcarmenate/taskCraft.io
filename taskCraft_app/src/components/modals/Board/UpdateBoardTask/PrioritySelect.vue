<script setup>
import { computed, ref, watch } from 'vue'

// Constants
const TASK_PRIORITIES = [
  { value: 'low', text: 'Low' },
  { value: 'high', text: 'High' },
]

// Properties
const props = defineProps({
  priority: {
    type: [String, null],
    required: true
  }
})

// Data
const newPriority = ref(props.priority)
const editingPriority = ref(false)


// Computed properties
const taskPriority = computed(() => {
  if (!props.priority) return ''
  return capitalizeFirstLetter(props.priority)
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

}

// Watch for priority changes and trigger form submission
watch(newPriority, (newValue) => {
  console.log(newValue)
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
