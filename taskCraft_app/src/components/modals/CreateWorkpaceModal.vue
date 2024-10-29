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
defineProps({
  show: {
    type: Boolean,
    default: false
  }
})
const step = ref(1)
const stepEmail = ref(null)
const workspace = useWorkspace()
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

const onSubmit = async () => {
  try {
    localState.sending = true
    const response = await workspace.createWorkspace({
      name: localState.form.name,
      type: localState.form.type,
      description: localState.form.description
    })

    if (response.status >= 200 && response.status < 300) {
      notify('success', `Workspace ${localState.form.name} was create successfully`)
      step.value = 2

      workspace.workspaceSelected = response?.data?.data ?? {}
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

const invitationLink = async () => {
  try {
    localState.gettingLink = true

    const response = await workspace.getOrCreateInvitationLink()

    if (response.status !== 200) {
      notify('error', 'Ops! something went wrong')
      return
    }

    const invitationLink = response?.data?.invitation ?? ""
    console.log(invitationLink)
    if (invitationLink) {
      navigator.clipboard.writeText(invitationLink)
        .then(() => {
          notify('success', 'Link! copied successfully!')
        })
        .catch(() => {
          notify('error', 'Ops! something went wrong')
        })
    } else {
      notify('error', 'Ops! something went wrong')
    }

  } catch (e) {
    console.error('error getting link', e)

    notify('error', 'Oops! something went wrong')
  } finally {
    localState.gettingLink = false
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
        v-if="step===1"
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
          <div class="use__invitation-link mt-4">
            <p>Or use invitation link</p>
            <button
              @click="invitationLink()"
              type="button"
              class="py-1 px-2 ms-3 text-sm font-medium text-xs text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            >
              Use Link
            </button>
          </div>

          <div class="form__controls mt-4">
            <p class="underline hand" @click="handleUpdateShow(false)">You can skip this step and add members later</p>
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
.use__invitation-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.hand {
  cursor: pointer;
}
</style>
