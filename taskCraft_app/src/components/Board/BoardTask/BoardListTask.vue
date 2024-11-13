<script setup>
const emit = defineEmits(['update:task'])
const props = defineProps({
  taskElement: {
    type: Object,
    required: true
  },
})

const selectTask = () => {
  emit('update:task', props.taskElement )
}

</script>

<template>
  <div
    :key="taskElement.id"
    class="task hand bg-blue-100 p-2 rounded shadow dark:bg-gray-900 list-group-item"
    @click="selectTask"
  >
    {{ taskElement.title }}
  </div>
</template>

<style scoped>
.hand {
  cursor:pointer;
}
</style>
