<script setup>
import {Form} from "vee-validate";
import TCModal from "@/components/modals/TCModal.vue";
import useNotification from "@/composables/useNotification.js";
import {computed, reactive, ref, watch} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";
import {useBoardStore} from "@/stores/useBoardStore.js";
import TextareaInput from "@/components/fields/TextareaInput.vue";
import TextInput from "@/components/fields/TextInput.vue";


// Emits and Props
const emit = defineEmits(['update:show'])
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  selectedTask: {
    type: Object,
    required: true
  }
})

// Stores and Composables
const board = useBoardStore()
const { notify } = useNotification()

const localTask = ref()
const editingDescription = ref(false)

// Data
const localState = reactive({
  form: {
    title: null,
    workspaceSelected: null,
    visibility: null
  },
  sending: false,
})

// Computed properties
const editDescriptionValidationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      taskDescription: zod.string().nullable(),
    })
  )
})

watch(() => props.selectedTask, (newValue) => {
  if (newValue) {
    localTask.value = props.selectedTask
    console.log(localTask.value)
  }
},
  { immediate: true }
)


// Methods
const handleUpdateShow = (show) => {
  emit('update:show', show)
}

const descriptionSubmit = async () => {
  try {
    localState.sending = true
    const response = await board.updateTaskDescription({
      taskId: localTask.value.id,
      taskDescription: localTask.value.description,
    })

    if (response.status >= 200 && response.status < 300) {
      notify('success', `Task description updated`)

      editingDescription.value = false
    } else {
      notify('error', 'Ops! something went wrong')
    }
  } catch (e) {
    console.error(e)

    notify('error', 'Ops! something went wrong')
  } finally {
    localState.sending = false
  }
}

const invalidDescriptionSubmit = (e) => {
  console.log('Invalid submit', e)
}

const updateTaskTitle = async (newTitle) => {
  if (newTitle) {
    try {
      const response = await board.updateTaskTitle({
        taskId: localTask.value.id,
        newTitle
      })

      if (response.status !== 200) {
        notify('error', 'Oops something went wrong!')
        return
      }

      localTask.value.title = newTitle
      board.lists?.tasks?.forEach((task) => {
        if (task.id === localTask.value.id) {
          task.title = localTask.value.title
        }
      })

    } catch (e) {
      console.log(e)

      notify('error', 'Oops something went wrong!')
    }
  }
}

const handleEditDescription = () => {
  editingDescription.value = true
}

const cancelEditDescription = () => {
  editingDescription.value = false
}

</script>

<template>
  <TCModal
    :title="localTask.title"
    :show="show"
    @update:show="handleUpdateShow"
    :editable-title="true"
    :call-back-editable-title="updateTaskTitle"
  >
    <template #body>
      <div class="task-container p-2 grid grid-cols-[4fr_2fr]">
        <!-- Main Content -->
        <div class="p-4">
          <div class="description-section">
            <h3 class="text-xl font-thin">Description</h3>
            <div
              v-if="!editingDescription"
              class="description-content rounded-md p-4 bg-gray-500 mt-3 cursor-pointer"
              @click="handleEditDescription"
            >
              <p class="text-gray-700" v-if="localTask.description">
                {{ localTask.description }}
              </p>
              <p v-else>
                Added a more detailed description
              </p>
            </div>
            <div
              v-else
            >
              <Form
                class="flex flex-col"
                :validation-schema="editDescriptionValidationSchema"
                @submit="descriptionSubmit"
                @invalidSubmit="invalidDescriptionSubmit"
              >
                <TextareaInput
                  name="taskDescription"
                  placeholder="Add a detailed description"
                  v-model="localTask.description"
                />
                <div class="description-actions flex flex-row gap-2 justify-start mt-2">
                  <button
                    class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    type="submit"
                  >
                    save
                  </button>
                  <button
                    class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-danger-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-danger-700"
                    type="button"
                    @click="cancelEditDescription"
                  >
                    Cancel
                  </button>
                </div>
              </Form>
            </div>

            <div class="activity-container flex flex-col mt-24">
              <h3 class="text-xl font-thin">Activity</h3>
              <div class="activity-content">
                <div class="">
                  <TextInput
                    placeholder="Comment"
                  ></TextInput>
                </div>
                <div>
                  activities
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- Side Content -->
        <div class="p-4 border-l border-solid border-secondary-600">
          <div class="details-container">
            <h3 class="text-xl font-thin">Details</h3>
            <div class="details-container mt-3">
              <div class="priority-container flex flex-row justify-between my-2">
                <div class="font-semibold">Priority</div>
                <div class="priority-value">{{ localTask.priority }}</div>
              </div>
              <div class="assignee-container flex flex-row justify-between my-2">
                <div class="font-semibold">Assignee</div>
                <div class="priority-value">{{ localTask.assigned_to ?? 'Unassigned' }}</div>
              </div>

              <div class="reporter-container flex flex-row justify-between my-2">
                <div class="font-semibold">Reporter</div>
                <div class="priority-value">{{ localTask.created_by?.name ?? 'No Reporter' }}</div>
              </div>

              <div class="reporter-container flex flex-row justify-between mt-12">
                <div class="font-semibold">Start Date</div>
                <div class="priority-value">{{ localTask.start_date ?? 'Set Start Date' }}</div>
              </div>
              <div class="reporter-container flex flex-row justify-between my-2">
                <div class="font-semibold">Due Date</div>
                <div class="priority-value">{{ localTask.due_date ?? 'Set Due Date' }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template #footer>
      <button
        @click="handleUpdateShow(false)"
        type="button"
        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
      >
        Close
      </button>
    </template>
  </TCModal>
</template>

<style scoped>

</style>
