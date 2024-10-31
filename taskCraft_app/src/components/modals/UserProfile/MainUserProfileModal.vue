<script setup>
import {Form} from "vee-validate";
import TextInput from "@/components/fields/TextInput.vue";
import TCModal from "@/components/modals/TCModal.vue";
import SelectInput from "@/components/fields/SelectInput.vue";
import {computed, onMounted, reactive, ref} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import { JOB_POSITIONS } from "@/constants/index.js";
import * as zod from "zod";
import ProfileImage from "@/components/Profile/profile-images/ProfileImage.vue";
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import {useUserStore} from "@/stores/useUserStore.js";
import useNotification from "@/composables/useNotification.js";
import TCButton from "@/components/fields/TCButton.vue";

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
    name: null,
    jobPosition: null,
    profileImage: null
  },
  updating: false
})

const jobPositions = ref(JOB_POSITIONS)
const userProfileTitle = computed(() => {
  return "Edit Your Main User Profile Info"
})

onMounted(() => {
  localState.form.name = user.name
  localState.form.jobPosition = userProfile.jobPosition
})

const handleUpdateShow = (value) => {
  emit('update:show', value)
}

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      name: zod.string().optional().nullable(),
      jobDescription: zod.string().optional().nullable(),
    })
  )
})

const handleUpdateImage = (file) => {
  localState.form.profileImage = file
}

const onSubmit = async () => {
  try {
    localState.updating = true
    const response = await userProfile.updateMainUserProfile({
      name: localState.form.name,
      jobPosition: localState.form.jobPosition,
      file: localState.form.profileImage
    })

    if (response.status === 200) {
      notify('success', 'User profile info updated successfully')

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
      <div class="flex flex-row gap-3 justify-center">
        <ProfileImage
          @updated:image="handleUpdateImage"
        />
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
                label="User Name"
                placeholder="John Doe"
                v-model="localState.form.name"
                show-error
              />
            </div>
          </div>
          <div class="form__row mt-4">
            <div class="form__controls">
              <SelectInput
                name="jobPosition"
                :items="jobPositions"
                label="Job Position"
                v-model="localState.form.jobPosition"
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
