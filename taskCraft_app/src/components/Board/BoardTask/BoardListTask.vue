<script setup>
defineProps({
  taskElement: {
    type: Object,
    required: true
  },
})
</script>

<template>
  <div
    :key="taskElement.id"
    class="task bg-blue-100 p-2 rounded shadow dark:bg-gray-900"
  >
    {{ taskElement.name }}
  </div>
</template>

<style scoped>

</style>
