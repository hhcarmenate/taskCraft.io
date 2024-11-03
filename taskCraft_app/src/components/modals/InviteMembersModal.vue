<script setup>
import TCModal from "@/components/modals/TCModal.vue";
import {Form} from 'vee-validate'
import {computed, reactive, ref} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from 'zod'
import TextInput from "@/components/fields/TextInput.vue";
import SelectInput from "@/components/fields/SelectInput.vue";
import TextareaInput from "@/components/fields/TextareaInput.vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import useNotification from "@/composables/useNotification.js";
import InviteMembers from "@/components/modals/Workspace/InviteMembers.vue";

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

const resetValues = () => {
  step.value =
  localState.sending = false
  localState.gettingLink = false
}

const handleCloseModal = () => {
  resetValues()
  handleUpdateShow(false)
}


</script>

<template>
  <TCModal
    :title="workspaceTitle"
    :show="show"
    @update:show="handleUpdateShow"
  >
    <template #body>
      <div>
        <InviteMembers
          @close-modal="handleCloseModal"
        />
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
.hand {
  cursor: pointer;
}
</style>
