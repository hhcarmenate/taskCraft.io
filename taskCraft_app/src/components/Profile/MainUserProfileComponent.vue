<script setup>

import MainUserProfileModal from "@/components/modals/UserProfile/MainUserProfileModal.vue";
import ProfileImage from "@/components/Profile/profile-images/ProfileImage.vue";
import {useUserStore} from "@/stores/useUserStore.js";
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import {computed, ref} from "vue";
import {JOB_POSITIONS} from "@/constants/index.js";

const user = useUserStore()
const userProfile = useUserProfileStore()
const showUserProfileModal = ref(false)

const jobPosition = computed(() => {
  return JOB_POSITIONS.find((job) => job.value === userProfile.jobPosition)?.text
})

const openMainUserProfileModal = () => {
  showUserProfileModal.value = true
}

const handleUpdateShow = (value) => {
  showUserProfileModal.value = value
}

</script>

<template>
  <div class="w-[40%] max-w-sm bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-end px-4 pt-4">
      <button
        @click="openMainUserProfileModal()"
        class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
        type="button"
      >
        <span class="sr-only">Open dropdown</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
          <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
        </svg>
      </button>
    </div>
    <div class="flex flex-col items-center pb-10">
      <ProfileImage
        :editable="false"
      />
      <h5 class="mb-1 mt-3 text-xl font-medium text-gray-900 dark:text-white">
        {{ user.name }}
      </h5>
      <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ jobPosition ?? '' }}
              </span>
    </div>
    <MainUserProfileModal :show="showUserProfileModal" @update:show="handleUpdateShow" />
  </div>
</template>

<style scoped>

</style>
