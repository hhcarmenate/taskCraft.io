<script setup>
import { computed } from 'vue'
import LoadingIcon from '@/components/icon/LoadingIcon.vue'

// Properties and emits
const emit = defineEmits(['click'])
const props = defineProps({
  id: {
    type: String,
    required: true
  },
  type: {
    type: String,
    required: false,
    default: 'success',
    validator: (value) => ['success', 'warning', 'danger', 'info', 'default'].includes(value)
  },
  buttonText: {
    type: String,
    required: false,
    default: 'Click me'
  },
  buttonType: {
    type: String,
    required: true,
    default: 'button'
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false
  },
  reverse: {
    type: Boolean,
    required: false,
    default: false
  },
  loading: {
    type: Boolean,
    required: false,
    default: false
  }
})

const computedClasses = computed(() => {
  if (!props.reverse) {
    return noReverseStatus()
  }
  return reverseStatus()
})

const noReverseStatus = () => {
  switch (props.type) {
    case 'warning':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-warning-500
                    text-white rounded-md`
    case 'danger':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-danger-500
                    text-white rounded-md`
    case 'info':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-info-500
                    text-white rounded-md dark:bg-info-500 dark:text-gray-800`
    case 'default':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-secondary-300
                    text-black rounded-md`
    default:
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-green-500
                    text-white rounded-md`
  }
}

const reverseStatus = () => {
  switch (props.type) {
    case 'warning':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-transparent border border-warning
                    text-warning rounded-md`
    case 'danger':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-transparent border border-danger
                    text-danger rounded-md`
    case 'info':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 bg-transparent border border-meta-10
                    text-meta-10 rounded-md`
    case 'default':
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 border border-meta-9
                    text-meta-9 rounded-md`
    default:
      return `inline-flex items-center justify-center gap-2.5 py-2 px-10 text-center
                    font-medium hover:bg-opacity-90 lg:px-8 xl:px-10 border border-success
                    text-success rounded-md`
  }
}
</script>

<template>
  <button
    :id="id"
    :class="computedClasses"
    :disabled="disabled || loading"
    :type="buttonType"
    @click="emit('click')"
  >
    <span v-if="!loading">
      {{ buttonText }}
    </span>
    <span
      v-else
      class="flex flex-row items-center"
    >
      <LoadingIcon />
      <span class="ml-1">Sending...</span>
    </span>
  </button>
</template>

<style scoped></style>
