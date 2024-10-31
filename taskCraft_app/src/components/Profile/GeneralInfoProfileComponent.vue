<script setup>
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import GeneralInfoProfileModal from "@/components/modals/UserProfile/GeneralInfoProfileModal.vue";
import {computed, ref} from "vue";
import {USA_TIMEZONES} from "@/constants/index.js";

const showGeneralInfoModal = ref(false)
const userProfile = useUserProfileStore()

const handleShowGeneralInfoModal = (value) => {
  showGeneralInfoModal.value = value
}

const uiModeString = computed(() => {
  if (!userProfile.uiMode) return 'N/A'
  return userProfile.uiMode.charAt(0).toUpperCase() + userProfile.uiMode.slice(1)
})

const timezoneSelected = computed(() => {
  if (!userProfile.timezone) return 'N/A'
  return USA_TIMEZONES.find((timezone) => timezone.value === userProfile.timezone).text
})

</script>

<template>
  <div class="w-[100%] max-w-lg p-3 bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="card-container flex flex-col">
      <div class="flex flex-row justify-between items-center">
        <div class="w-1/2">
          <h1 class="font-medium text-3xl">General Info</h1>
        </div>

        <div class="flex justify-end w-1/2">
          <button
            class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
            type="button"
            @click="handleShowGeneralInfoModal(true)"
          >
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
              <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
            </svg>
          </button>
        </div>
      </div>
      <div class="flex flex-row justify-between items-center">
        <div
          class="p-2 bg-white rounded-lg md:p-4 dark:bg-gray-800"
        >
          <h2
            class="mb-3 text-2xl font-extra-bold tracking-tight text-gray-900 dark:text-white"
          >
            About me
          </h2>
          <p
            class="mb-3 text-gray-500 dark:text-gray-400"
          >
            {{ userProfile.bio ?? 'N/A' }}
          </p>
        </div>
      </div>

      <div
        class="p-2 bg-white rounded-lg md:p-2 dark:bg-gray-800"
        aria-labelledby="statistics-tab"
      >
        <dl
          class="grid max-w-screen-xl grid-cols-2 gap-4 p-2 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white"
        >
          <div
            class="flex flex-col"
          >
            <dt class="mb-2 text-xl ">
              UI Mode
            </dt>
            <dd
              class="text-gray-500 dark:text-gray-400"
            >
              {{ uiModeString }}
            </dd>
          </div>
          <div
            class="flex flex-col"
          >
            <dt
              class="mb-2 text-xl"
            >
              Language
            </dt>
            <dd
              class="text-gray-500 dark:text-gray-400"
            >
              {{ userProfile.language ?? 'N/A' }}
            </dd>
          </div>
          <div class="flex flex-col">
            <dt class="mb-2 text-xl">
              Timezone
            </dt>
            <dd class="text-gray-500 dark:text-gray-400">
              {{ timezoneSelected }}
            </dd>
          </div>
        </dl>
      </div>
    </div>
    <GeneralInfoProfileModal
      :show="showGeneralInfoModal"
      @update:show="handleShowGeneralInfoModal(false)"
    />
  </div>
</template>

<style scoped>

</style>
