<script setup>
import { computed, ref, toRef, watch } from 'vue'
import { useField } from 'vee-validate'

// Emits and pros
const emit = defineEmits(['resetErrors', 'update:modelValue', 'update:blur'])
const props = defineProps({
  label: { type: String },
  classLabel: { type: String, default: ' ' },
  classInput: { type: String, default: 'classinput' },
  name: { type: String },
  modelValue: { type: String, default: '' },
  hasIcon: { type: Boolean, default: false },
  isReadonly: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
  horizontal: { type: Boolean, default: false },
  validate: { type: String },
  msgTooltip: { type: Boolean, default: false },
  description: { type: String },
  showError: { type: Boolean, default: false },
  items: { type: Array, default: [] }
})

// Data
const types = ref(props.type)
const name = toRef(props, 'name')

const {
  value: inputValue,
  errorMessage,
  handleBlur,
  handleChange,
  setValue,
  meta
} = useField(name, {
  initialValue: props.modelValue ?? 0
})

// Hooks
watch(() => props.modelValue, setValue)

watch(inputValue, (val) => {
  emit('update:modelValue', val)
  if (val) {
    emit('resetErrors')
  }
})

const showErrorMessage = computed(() => {
  return props.showError && errorMessage.value && meta.touched
})

const handleFieldBlur = (e) => {
  emit('update:blur', e.target.value)
  handleBlur(e)
}

</script>

<template>
  <div
    :class="`${showErrorMessage ? 'has-error' : ''}  ${horizontal ? 'flex' : ''}  ${validate ? 'is-valid' : ''} `"
    class="fromGroup relative"
  >
    <label
      :for="name"
      :class="`${classLabel} ${horizontal ? 'flex-0 mr-6 md:w-[100px] w-[60px] break-words' : ''}  ltr:inline-block rtl:block input-label`"
    >
      {{ label }}
    </label>
    <select
      :id="name"
      class="bg-gray-50 input-control mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="inputValue"
      @blur="handleFieldBlur"
      @change="handleChange"
    >
      <option
        v-for="item in items"
        :value="item.value"
        :key="item.value"
      >
        {{ item.text }}
      </option>
    </select>

    <span
      v-if="showErrorMessage"
      :class="
        msgTooltip
          ? ' inline-block bg-danger-500 text-white text-[10px] px-2 py-1 rounded'
          : ' text-danger-500 block text-sm'
      "
      class="mt-2"
    >
      {{ errorMessage }}
    </span>
  </div>
</template>

<style scoped>
.has-error label {
  color: rgb(241 89 92 / var(--tw-text-opacity));
}

.fromGroup {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;

  .input-control {
    background-color: transparent;
    border: solid 1px #808da5;
    border-radius: 4px;
  }
}
</style>
