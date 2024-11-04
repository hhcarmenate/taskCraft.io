<script setup>
defineProps({
  board: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="bg-blue-200 rounded rounded-4 p-6 hand">
    {{ board.name }}
  </div>
</template>

<style scoped>
.hand {
  cursor: pointer;
}
</style>
