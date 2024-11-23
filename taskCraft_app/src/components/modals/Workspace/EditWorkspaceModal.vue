<script setup>
import TCModal from "@/components/modals/TCModal.vue"
import {Form} from 'vee-validate'
import {computed, reactive, watch} from "vue"
import {toTypedSchema} from "@vee-validate/zod"
import * as zod from 'zod'
import TextInput from "@/components/fields/TextInput.vue"
import SelectInput from "@/components/fields/SelectInput.vue"
import TextareaInput from "@/components/fields/TextareaInput.vue"
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js"
import useNotification from "@/composables/useNotification.js"

const currentItems = [
  { value: 'education', text: 'Education' },
  { value: 'salesCrm', text: 'Sales CRM' },
  { value: 'humanResources', text: 'Human Resources' },
]

const emit = defineEmits(['update:show'])
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const workspace = useWorkspaceStore()
const { notify } = useNotification()

const localState = reactive({
  form: {
    name: null,
    type: null,
    description: null
  },
  sending: false,
  gettingLink: false
})

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      name: zod.string().min(5, {message: 'Workspace name must have at least 5 characters'}),
      type: zod.string(),
      description: zod.string().optional().nullable()
    })
  )
})

watch(() => props.show, (newValue) => {
  if (newValue) {
    initLocalState()
  }
})

const handleUpdateShow = (show) => {
  emit('update:show', show)
}

const onSubmit = async () => {
  try {
    localState.sending = true
    const response = await workspace.updateWorkspace({
      name: localState.form.name,
      type: localState.form.type,
      description: localState.form.description
    })

    if (response.status >= 200 && response.status < 300) {
      notify('success', `Workspace ${localState.form.name} was updated successfully`)
      workspace.currentWorkspace = response?.data?.data ?? {}

      emit('update:show', false)
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

const resetValues = () => {
  localState.form = {
    name: null,
    type: null,
    description: null,
  }
  localState.sending = false
  localState.gettingLink = false
}

const initLocalState = () => {
  if (workspace.currentWorkspace) {
    localState.form.name = workspace.currentWorkspace.name
    localState.form.type = workspace.currentWorkspace.type
    localState.form.description = workspace.currentWorkspace.description
  }
}

const handleCloseModal = () => {
  resetValues()
  handleUpdateShow(false)
}

const onInvalidSubmit = (e) => {
  console.log('Invalid submit', e)
}

</script>

<template>
  <TCModal
    :title="'Edit Workspace Info'"
    :show="show"
    @update:show="handleUpdateShow"
  >
    <template #body>
      <div class="flex flex-row gap-3 justify-center">
        <div class="image-container w-[50%]">
          <img
            src="/images/workspace.svg"
            alt=""
          />
        </div>
      </div>

      <Form
        class="space-y-4"
        :validation-schema="validationSchema"
        @submit="onSubmit"
        @invalid-submit="onInvalidSubmit"
      >
        <div class="form__section flex flex-col">
          <div class="form__row">
            <div class="form__controls">
              <TextInput
                name="name"
                type="text"
                label="Workspace Name"
                placeholder="Chocolate project"
                v-model="localState.form.name"
                show-error
              />
            </div>
          </div>
          <div class="form__row mt-8">
            <div class="form__controls">
              <SelectInput
                name="type"
                :items="currentItems"
                label="Workspace Type"
                v-model="localState.form.type"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-8">
            <div class="form__controls">
              <TextareaInput
                name="description"
                label="Workspace Description"
                placeholder="A brief description of your workspace"
                v-model="localState.form.description"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-4">
            <div class="form__controls flex justify-end">
              <button
                type="submit"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
              >
                Update
              </button>
            </div>
          </div>
        </div>
      </Form>
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
.hand {
  cursor: pointer;
}
</style>
