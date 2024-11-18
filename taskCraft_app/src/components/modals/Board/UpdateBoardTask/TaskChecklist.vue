<script setup>
import { computed, ref } from 'vue'
import TextInput from '@/components/fields/TextInput.vue'
import {Form} from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as zod from 'zod'
import useNotification from '@/composables/useNotification.js'
import { useBoardStore } from '@/stores/useBoardStore.js'

const creatingChecklist = ref(false)
const checklistTitle = ref('')
const { notify } = useNotification()
const board = useBoardStore()

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      title: zod.string({message: 'Title field is required!'})
    })
  )
})

const showCreateChecklist = () => {
  creatingChecklist.value = true
}

const cancelCreateChecklist = () => {
  creatingChecklist.value = false
}

const onSubmit = async () => {
  try {
    const response = await board.createTaskChecklist(checklistTitle.value)

    console.log(response)
    if (response.status === 201) {
      notify('success', 'Checklist created successfully')

      return
    }


    notify('error', 'Oops something went wrong')
  } catch(e) {
    console.log(e)

    notify('error', 'Oops something went wrong')
  }
}

</script>

<template>
  <div class="check-list flex flex-row items-center justify-center">
    <div
      class="btn-container"
      v-if="!creatingChecklist"
    >
      <button
        class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
        type="button"
        @click="showCreateChecklist"
      >
        Create Checklist
      </button>
    </div>
    <div
      class="create-checklist-container"
      v-else
    >
      <div class="form-container">
        <Form
          class="checklist-form flex flex-row gap-2 items-center"
          :validation-schema="validationSchema"
          @submit="onSubmit"
        >
          <TextInput
            :placeholder="'Enter Checklist Name'"
            name="title"
            v-model="checklistTitle"
            show-error
          />

          <button
            class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            type="submit"
          >
            Create
          </button>

          <button
            class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-danger-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-danger-700"
            type="button"
            @click="cancelCreateChecklist"
          >
            Cancel
          </button>
        </Form>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
