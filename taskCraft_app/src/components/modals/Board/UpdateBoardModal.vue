<script setup>
import {Form} from "vee-validate"
import TextInput from "@/components/fields/TextInput.vue"
import TCModal from "@/components/modals/TCModal.vue"
import SelectInput from "@/components/fields/SelectInput.vue"
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js"
import useNotification from "@/composables/useNotification.js"
import {computed, reactive, watch} from "vue"
import {toTypedSchema} from "@vee-validate/zod"
import * as zod from "zod"
import {useBoardStore} from "@/stores/useBoardStore.js"
import {useUserStore} from "@/stores/useUserStore.js"
import RadioInput from '@/components/fields/RadioInput.vue'

const visibilityOptions = [
  { value: 'private', text: 'Private' },
  { value: 'public', text: 'Public' },
  { value: 'workspace', text: 'Workspace' },
]

// Emits and Props
const emit = defineEmits(['update:show'])
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

// Stores and Composables
const workspace = useWorkspaceStore()
const board = useBoardStore()
const user = useUserStore()

const { notify } = useNotification()

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
const formattedWorkspaces = computed(() => {
  return workspace.workspaces.map((work) => {
    return { value: work.id, text: work.name }
  })
})

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      title: zod.string().min(3, {message: 'Board title must have at least 3 characters long'}),
      workspaceSelected: zod.number({message: 'Workspace is required'}),
      visibility: zod.string({message: 'Visibility is required'})
    })
  )
})

watch(() => props.show, () => {
  initLocalState()
})

const initLocalState = () => {
  localState.form.title = board.title
  localState.form.workspaceSelected = board.workspace_id
  localState.form.visibility = board.visibility
}



// Methods
const handleUpdateShow = (show) => {
  emit('update:show', show)
}

const onSubmit = async () => {
  try {
    localState.sending = true
    const response = await board.updateBoard({
      title: localState.form.title,
      workspaceSelected: localState.form.workspaceSelected,
      visibility: localState.form.visibility
    })

    if (response.status >= 200 && response.status < 300) {
      notify('success', `Board ${localState.form.title} was updated successfully`)
      const { data } = response
      board.initCurrentBoard(data.data)
      await workspace.fetchUserWorkspaces(user.userId)
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

const onInvalidSubmit = (e) => {
  console.log('Invalid submit', e)
}

</script>

<template>
  <TCModal
    :title="'Update Board'"
    :show="show"
    @update:show="handleUpdateShow"
  >
    <template #body>
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
                name="title"
                type="text"
                label="Board Title"
                placeholder=""
                v-model="localState.form.title"
                show-error
              />
            </div>
          </div>
          <div class="form__row mt-8">
            <div class="form__controls">
              <SelectInput
                name="workspaceSelected"
                :items="formattedWorkspaces"
                label="Workspace"
                v-model="localState.form.workspaceSelected"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-8">
            <div class="form__controls">
              <h3 class="text-md mb-3">Visibility</h3>
              <div class="options-container flex flex-row items-center justify-between">
                <template
                  v-for="option in visibilityOptions"
                  :key="option.id"
                >
                  <RadioInput
                    :id="`option_${option.value}`"
                    :label="option.text"
                    :checked="localState.form.visibility === option.value"
                    name="visibility"
                    v-model="localState.form.visibility"
                    :value="option.value"
                    :disabled="false"
                  />
                </template>
              </div>
            </div>
          </div>

          <div class="form__row mt-4">
            <div class="form__controls flex justify-end">
              <button
                type="submit"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
              >
                Update Board
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

</style>
