<script setup>
import TextInput from "@/components/fields/TextInput.vue";
import {computed, reactive, ref} from "vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import useNotification from "@/composables/useNotification.js";
import TCButton from "@/components/fields/TCButton.vue";
import {Field, Form} from "vee-validate";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";
import TextareaInput from "@/components/fields/TextareaInput.vue";

// Emits
const emit = defineEmits(['closeModal'])

// Data
const guestEmail = ref(null)
const workspace = useWorkspaceStore()
const { notify } = useNotification()
const localState = reactive({
  gettingLink: false,
  sending: false,
  form: {
    invitationList: [],
    invitationText: ''
  }
})

// Computed
const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      guestEmail: zod.string().email(),
    })
  )
})

const invitationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      invitationList: zod.array(zod.string().email()).nonempty(),
      invitationText: zod.string().optional().nullable()
    })
  )
})

// Data
const invitationLink = async () => {
  try {
    localState.gettingLink = true

    const response = await workspace.getOrCreateInvitationLink()

    if (response.status !== 200) {
      notify('error', 'Ops! something went wrong')
      return
    }

    const invitationLink = response?.data?.invitation ?? ""
    if (navigator.clipboard) {
      // Use the Clipboard API to copy text
      navigator.clipboard.writeText(invitationLink).then(() => {
        notify('success', 'Invitation link copied successfully');
      }).catch(err => {
        console.error('Could not copy text: ', err);
      });
    } else {
      // Fallback for older browsers or environments without Clipboard API
      const textArea = document.createElement('textarea');
      textArea.value = invitationLink;

      // Avoid scrolling to bottom
      textArea.style.position = 'fixed';
      textArea.style.top = 0;
      textArea.style.left = 0;

      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();

      try {
        document.execCommand('copy');
        notify('success', 'Invitation link copied successfully');
      } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
      }

      document.body.removeChild(textArea);
    }

  } catch (e) {
    console.error('error getting link', e)

    notify('error', 'Oops! something went wrong')
  } finally {
    localState.gettingLink = false
  }
}

const onGuestSubmit = (fields, actions) => {
  localState.form.invitationList.push(guestEmail.value)
  guestEmail.value = ''
  actions.resetForm()
}

const resetValues = () => {
  guestEmail.value = ''
  localState.form.invitationList = []
  localState.form.invitationText = ''
  localState.gettingLink = false
  localState.sending = false
}

const onSubmitInvitation = async (fields) => {
  try {
    localState.sending = true

    const response = await workspace.sendInvitation(fields)

    if (response.status === 200) {
      notify('success', 'Invitation sent successfully!')
      resetValues()
      emit('closeModal')
    } else {
      notify('error', 'Oops! something went wrong')
    }


  } catch (e) {
    console.error(e)

    notify('error', 'Oops! something went wrong')
  } finally {
    localState.sending = false
  }
}


const removeFromList = (invitation) => {
  localState.form.invitationList = localState.form.invitationList.filter((inv) => inv !== invitation)
}


</script>

<template>
  <div class="form__section flex flex-col">
    <div class="form__row">
      <div class="form__controls">
        <Form
          class="flex flex-row gap-3"
          :validation-schema="validationSchema"
          @submit="onGuestSubmit"
        >
          <TextInput
            name="guestEmail"
            type="guestEmail"
            placeholder="Email address"
            v-model="guestEmail"
            show-error
            class="w-full"
          />

          <TCButton
            id="invitation-btn"
            button-type="submit"
            button-text="Add"
            type="success"
          />
        </Form>
      </div>
      <div v-if="localState.form.invitationList.length">
        <Form
          :validation-schema="invitationSchema"
          @submit="onSubmitInvitation"
        >
          <Field
            name="invitationList"
            :model-value="localState.form.invitationList"
          >
            <ul>
              <li
                class="mt-2"
                v-for="invitation in localState.form.invitationList"
                :key="invitation"
              >
            <span
              class="flex flex-row justify-between w-1/2 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
            >
              <span>{{ invitation }}</span>
              <span class="hand" @click="removeFromList(invitation)">X</span>
            </span>

              </li>
            </ul>
          </Field>

          <div class="form__row mt-4">
            <div class="form__controls">
              <TextareaInput
                name="invitationText"
                label="Invitation"
                placeholder="Explain your invitation"
                v-model="localState.form.invitationText"
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
                Send
              </button>
            </div>
          </div>
        </Form>
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
