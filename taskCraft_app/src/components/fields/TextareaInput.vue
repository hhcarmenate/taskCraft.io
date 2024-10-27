<script setup>
import Icon from '@/components/icon/TCIcon.vue'
import { computed, ref, toRef, watch } from 'vue'
import { useField } from 'vee-validate'
import TCIcon from "@/components/icon/TCIcon.vue";

const emit = defineEmits(['resetErrors', 'update:modelValue', 'update:blur'])
const props = defineProps({
  placeholder: { type: String, default: 'Search' },
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
  options: {
    type: Object,
    default: () => ({
      creditCard: true,
      delimiter: '-'
    })
  }
})

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
  initialValue: props.modelValue
})

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
      v-if="label"
      :class="`${classLabel} ${horizontal ? 'flex-0 mr-6 md:w-[100px] w-[60px] break-words block mb-2 text-sm font-medium text-gray-900 dark:text-white' : ''}  ltr:inline-block rtl:block input-label`"
      :for="name"
    >
      {{ label }}
    </label>
    <div
      :class="horizontal ? 'flex-1' : ''"
      class="relative w-full mt-1"
    >
      <textarea
        id="message"
        rows="5"
        :class="`${classInput} input-control block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500`"
        :disabled="disabled"
        :name="name"
        :placeholder="placeholder"
        :readonly="isReadonly"
        :value="modelValue"
        @blur="handleFieldBlur"
        @input="handleChange"
      >
      </textarea>
    </div>

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
    <span
      v-if="validate"
      :class="
        msgTooltip
          ? ' inline-block bg-success-500 text-white text-[10px] px-2 py-1 rounded'
          : ' text-success-500 block text-sm'
      "
      class="mt-2"
    >
      {{ validate }}
    </span>
    <span
      v-if="description"
      class="block text-secondary-500 font-light leading-4 text-xs mt-2"
    >
      {{ description }}
    </span>
  </div>
</template>

<style lang="scss" scoped>
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
    padding: 12px;
    resize: none;
  }
}
</style>
