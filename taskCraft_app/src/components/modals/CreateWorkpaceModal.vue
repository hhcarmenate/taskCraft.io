<script setup>
import TCModal from "@/components/modals/TCModal.vue";
import {Form} from 'vee-validate'
import {computed, reactive, ref} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from 'zod'
import TextInput from "@/components/fields/TextInput.vue";
import SelectInput from "@/components/fields/SelectInput.vue";
import TextareaInput from "@/components/fields/TextareaInput.vue";
import {useWorkspace} from "@/stores/useWorkspace.js";
import useNotification from "@/composables/useNotification.js";

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
const step = ref(1)
const stepEmail = ref(null)
const workspace = useWorkspace()
const notify = useNotification()

const localState = reactive({
  form: {
    name: null,
    type: null,
    description: null
  },
  sending: false
})

const workspaceTitle = computed(() =>
  step.value === 1 ? 'Create Workspace' : 'Invite to Workspace'
)

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      name: zod.string().min(5, {message: 'Workspace name must have at least 5 characters'}),
      type: zod.string(),
      description: zod.string().optional().nullable()
    })
  )
})

const handleUpdateShow = (show) => {
  emit('update:show', show)
}

const handleSubmit = () => {

}

const onSubmit = async () => {
  try {
    localState.sending = true
    const response = await workspace.createWorkspace({
      name: localState.form.name,
      type: localState.form.type,
      description: localState.form.description
    })

    notify('success', `Workspace ${localState.form.name} was create successfully`)
    step.value = 2

  } catch (e) {
    console.error(e)

    notify('error', 'Ops! something went wrong')
  } finally {
    localState.sending = false
  }
}

const onInvalidSubmit = (e) => {
  console.log('Invalid submit', e)
}

</script>

<template>
  <TCModal
    :title="workspaceTitle"
    :show="show"
    @update:show="handleUpdateShow"
  >
    <template #body>
      <Form
        class="space-y-4"
        :validation-schema="validationSchema"
        @submit="onSubmit"
        @invalid-submit="onInvalidSubmit"
        v-if="step===2"
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
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Continue
              </button>
            </div>
          </div>
        </div>
      </Form>
      <div v-else>
        <div class="form__section flex flex-col">
          <div class="form__row">
            <div class="form__controls">
              <TextInput
                name="guestEmail"
                type="email"
                placeholder="Email address"
                v-model="stepEmail"
                show-error
              />
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
