<script setup>
import SelectInput from '@/components/fields/SelectInput.vue'
import { computed, ref, watch } from 'vue'
import { Form, useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as zod from 'zod'

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
const priorityForm = ref()

const validationSchema = toTypedSchema(zod.object({
  newPriority: zod.string().nonempty('Priority field is required!')
}))

const { handleSubmit } = useForm()

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

// Handle form submission
const onSubmit = handleSubmit(fields => {
  console.log('Form submitted:', fields)
})

// Handle invalid submission
const onInvalidSubmit = (error) => {
  console.log('Form submission error:', error)
}

// Watch for priority changes and trigger form submission
watch(newPriority, () => {
  if (priorityForm.value) {
    priorityForm.value.submitForm().then(onSubmit).catch(onInvalidSubmit)
  }
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
      <Form
        ref="priorityForm"
        :validation-schema="validationSchema"
        @submit="onSubmit"
        @invalid-submit="onInvalidSubmit"
      >
        <SelectInput
          name="newPriority"
          :items="TASK_PRIORITIES"
          v-model="newPriority"
          show-error
        />
      </Form>
    </span>
  </div>
</template>

<style scoped>
</style>
