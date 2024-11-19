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

const hasChecklist = computed(() => {
  return !!Object.keys(board.selectedTask.checklist).length
})

const checklistName = computed(() => {
  if (hasChecklist.value) {
    return board.selectedTask?.checklist?.title ?? ''
  }

  return ''
})

const checkListItems = computed(() => {
  if (!board.selectedTask?.checklist?.checklist_items) {
    return []
  }

  return board.selectedTask.checklist.checklist_items
})

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      title: zod.string({message: 'Title field is required!'})
    })
  )
})

const checklistItemValidationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      description: zod.string({message: 'Description field is required!'})
    })
  )
})

const showCreateChecklist = () => {
  creatingChecklist.value = true
}

const cancelCreateChecklist = () => {
  creatingChecklist.value = false
}

const addChecklistItem = async (fields) => {
  try {
    const response = await board.addChecklistItem(fields)

    if (response.status === 201) {
      console.log(response)

      notify('success', 'Checklist item added successfully')
      return
    }

    notify('error', 'Oops something went wrong')
  } catch (e) {
    console.log(e)

    notify('error', 'Oops something went wrong')
  }
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
    <div class="checklists-container w-[65%]">
      <div
        class="have-checkList"
        v-if="hasChecklist"
      >
        <div class="w-full max-w-md p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-4 dark:bg-gray-800 dark:border-gray-700">
          <div class="flex items-center justify-between mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
              {{ checklistName }}
            </h5>
            <a
              href="#"
              class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
            >
              View all
            </a>
          </div>

          <div class="flex flex-row">
            <Form
              :validation-schema="checklistItemValidationSchema"
              @submit="addChecklistItem"
              class="flex flex-row justify-start items-center gap-2"
            >
              <TextInput
                name="description"
                placeholder="Add new Item"
              />
              <button
                class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                type="submit"
              >
                Add
              </button>
            </Form>
          </div>

          <div class="flow-root">
            <ul
              v-if="checkListItems.length"
              role="list"
              class="divide-y divide-gray-200 dark:divide-gray-700"
            >
              <li
                class="py-3 sm:py-4"
                v-for="item in checkListItems"
                :key="item.id"
              >
                <div class="flex items-center">
                  <div class="flex-shrink-0" />
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-500 truncate dark:text-gray-400"
                      :class="{'line-through': item.completed}"
                    >
                      {{ item.description }}
                    </p>
                  </div>
                  <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    <input
                      id="terms"
                      type="checkbox"
                      :value="'completed'"
                      :checked="item.completed"
                      class="w-4 h-4 cursor-pointer border border-gray-300 rounded bg-gray-50
                            focus:ring-3 focus:ring-blue-300 dark:bg-gray-700
                            dark:border-gray-600 dark:focus:ring-blue-600
                            dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                    />
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div v-else>
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
    </div>
  </div>
</template>

<style scoped>

</style>
