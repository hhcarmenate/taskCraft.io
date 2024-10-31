<script setup>
import {Form} from "vee-validate";
import TCModal from "@/components/modals/TCModal.vue";
import SelectInput from "@/components/fields/SelectInput.vue";
import {computed, onMounted, reactive, ref} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import { UI_MODES } from "@/constants/index.js";
import { LANGUAGES } from "@/constants/index.js";
import { USA_TIMEZONES } from "@/constants/index.js";
import * as zod from "zod";
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import {useUserStore} from "@/stores/useUserStore.js";
import useNotification from "@/composables/useNotification.js";
import TCButton from "@/components/fields/TCButton.vue";
import TextareaInput from "@/components/fields/TextareaInput.vue";

const userProfile = useUserProfileStore()
const user = useUserStore()
const { notify } = useNotification()
const emit = defineEmits(['update:show'])
defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const localState = reactive({
  form: {
    bio: null,
    uiMode: null,
    language: null,
    timezone: null
  },
  updating: false
})

const uiModes = ref(UI_MODES)
const languages = ref(LANGUAGES)
const timezones = ref(USA_TIMEZONES)
const userProfileTitle = computed(() => {
  return "Edit Your General Profile Info"
})

onMounted(() => {
  localState.form.bio = userProfile.bio
  localState.form.uiMode = userProfile.uiMode
  localState.form.language = userProfile.language
  localState.form.timezone = userProfile.timezone
})

const handleUpdateShow = (value) => {
  emit('update:show', value)
}

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      bio: zod.string().optional().nullable(),
      uiMode: zod.string().optional().nullable(),
      language: zod.string().optional().nullable(),
      timezone: zod.string().optional().nullable(),
    })
  )
})


const onSubmit = async () => {
  try {
    localState.updating = true
    const response = await userProfile.updateMainUserProfile({
      bio: localState.form.bio,
      uiMode: localState.form.uiMode,
      language: localState.form.language,
      timezone: localState.form.timezone
    })

    if (response.status === 200) {
      notify('success', 'General Info User profile was updated successfully')

      await userProfile.fetchUserProfile(user.userId)
      emit('update:show', false)
    } else {
      notify('error', 'Ops! something went wrong')
    }

  } catch (e) {
    console.error(e)

    notify('error', 'Ops! something went wrong')
  } finally {
    localState.updating = false
  }
}

const onInvalidSubmit = (error) => {
  console.log(error)
}

</script>

<template>
  <TCModal
    :title="userProfileTitle"
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
              <TextareaInput
                name="bio"
                label="About me(Bio)"
                placeholder="Enter a brief description of yourself"
                v-model="localState.form.bio"
                show-error
              />
            </div>
          </div>
          <div class="form__row mt-4">
            <div class="form__controls">
              <SelectInput
                name="uiMode"
                :items="uiModes"
                label="UI Mode"
                v-model="localState.form.uiMode"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-4">
            <div class="form__controls">
              <SelectInput
                name="language"
                :items="languages"
                label="Language"
                v-model="localState.form.language"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-4">
            <div class="form__controls">
              <SelectInput
                name="timezone"
                :items="timezones"
                label="Timezone"
                v-model="localState.form.timezone"
                show-error
              />
            </div>
          </div>

          <div class="form__row mt-4">
            <div class="form__controls flex justify-end">
              <TCButton
                :loading="localState.updating"
                id="submitButton"
                button-type="submit"
                type="success"
                button-text="Save"
                class="w-full"
              />
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
