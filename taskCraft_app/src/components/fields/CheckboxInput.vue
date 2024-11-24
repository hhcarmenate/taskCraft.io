<script setup>
import { computed, toRef, watch } from 'vue'
import { useField } from 'vee-validate'

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
  label: { type: String },
  name: { type: String },
  modelValue: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
})

const name = toRef(props, 'name')

const {
  value: checkboxValue,
  errorMessage,
  setValue,
  meta,
} = useField(name, {
  initialValue: props.modelValue,
})

watch(() => props.modelValue, setValue)

watch(checkboxValue, (val) => {
  emit('update:modelValue', val)
})

const showErrorMessage = computed(() => {
  return errorMessage.value && meta.touched
})
</script>

<template>
  <div :class="`formGroup relative ${showErrorMessage ? 'has-error' : ''}`">
    <label
      :for="name"
      class="input-label"
    >
      <input
        :id="name"
        type="checkbox"
        :name="name"
        :disabled="props.disabled"
        v-model="checkboxValue"
        class="w-4 h-4 cursor-pointer border border-gray-300 rounded bg-gray-50
          focus:ring-3 focus:ring-blue-300 dark:bg-gray-700
          dark:border-gray-600 dark:focus:ring-blue-600
          dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
      />
      <span class="ml-2">{{ props.label }}</span>
    </label>

    <span
      v-if="showErrorMessage"
      class="text-danger-500 block text-sm mt-2"
    >
      {{ errorMessage }}
    </span>
  </div>
</template>

<style lang="scss" scoped>
.has-error label {
  color: rgb(241 89 92 / var(--tw-text-opacity));
}

.formGroup {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;

  .input-control {
    background-color: transparent;
    border: solid 1px #808da5;
    border-radius: 4px;
    padding: 12px;
  }
}
</style>
