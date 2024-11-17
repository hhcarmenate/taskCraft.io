<script setup>
import { useAttrs } from 'vue'

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

const attrs = useAttrs()

</script>

<template>
  <div
    v-bind="attrs"
    class="task hand bg-blue-100 p-2 rounded shadow dark:bg-gray-900 list-group-item"
    @click="selectTask"
  >
    <p>{{ taskElement.title }}</p>
  </div>
</template>

<style scoped>
.hand {
  cursor:pointer;
}
</style>
