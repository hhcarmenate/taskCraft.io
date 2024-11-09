<script setup>
import TextareaInput from "@/components/fields/TextareaInput.vue";
import {computed, ref} from "vue";
import {Form} from "vee-validate";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";

const emit = defineEmits(['update:cancel', 'update:new'])
const taskName = ref()

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      taskName: zod.string({message: 'Task title is required'})
        .min(5,{message: 'Task should have at least 5 characters long'})
    })
  )
})

const onSubmit = () => {
  emit('update:new', taskName.value)
}

const onInvalidSubmit = (error) => {
  console.log(error)
}

const cancelAddTask = () => {
  emit('update:cancel')
}

</script>

<template>
  <div class="flex flex-col">
    <Form
      :validation-schema="validationSchema"
      @submit="onSubmit"
      @invalid-submit="onInvalidSubmit"
    >
      <TextareaInput
        name="taskName"
        label="Task Title"
        show-error
        v-model="taskName"
        placeholder="Task Title"
      />
      <div class="flex flex-row gap-2">
        <button
          type="submit"
          class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                  bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                  hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                  dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                  dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
          Add
        </button>
        <button
          type="button"
          @click="cancelAddTask"
          class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                  bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                  hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                  dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-danger-400
                  dark:border-danger-600 dark:hover:text-danger-400 dark:hover:bg-gray-700">
          Cancel
        </button>
      </div>
    </Form>

  </div>
</template>

<style scoped>

</style>
