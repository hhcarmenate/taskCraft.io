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
  type: { type: String, default: 'text' },
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

const toggleType = () => {
  types.value = props.type === 'text' ? 'password' : 'text'
}

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
      :class="`${classLabel} ${horizontal ? 'flex-0 mr-6 md:w-[100px] w-[60px] break-words' : ''}  ltr:inline-block rtl:block input-label`"
      :for="name"
    >
      {{ label }}
    </label>
    <div
      :class="horizontal ? 'flex-1' : ''"
      class="relative w-full mt-1"
    >
      <input
        :id="name"
        :class="`${classInput} input-control w-full block focus:outline-none h-[40px] ${hasIcon ? 'ltr:pr-10 rtl:pl-10' : ''} `"
        :disabled="disabled"
        :name="name"
        :placeholder="placeholder"
        :readonly="isReadonly"
        :type="types"
        :value="modelValue"
        @blur="handleFieldBlur"
        @input="handleChange"
      />

      <div class="flex text-xl absolute ltr:right-[14px] rtl:left-[14px] top-1/2 -translate-y-1/2">
        <span
          v-if="hasIcon"
          class="cursor-pointer text-secondary-500"
          @click="toggleType"
        >
          <TCIcon
            v-if="types === 'password'"
            icon="heroicons-outline:eye"
          />
          <TCIcon
            v-else
            icon="heroicons-outline:eye-off"
          />
        </span>

        <span
          v-if="hasIcon && showErrorMessage"
          class="text-danger-500"
        >
          <Icon icon="heroicons-outline:information-circle" />
        </span>

        <span
          v-if="validate"
          class="text-success-500"
        >
          <Icon icon="bi:check-lg" />
        </span>
      </div>
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
    border: solid 1px #2c3e50;
    border-radius: 8px;
    padding: 12px;
  }
}


</style>
