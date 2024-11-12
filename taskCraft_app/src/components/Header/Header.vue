<script setup>
import { ref } from "vue"
import {useRouter} from "vue-router";
import CreateWorkspaceModal from "@/components/modals/Workspace/CreateWorkspaceModal.vue";
import {useUserStore} from "@/stores/useUserStore.js";
import HeaderWorkspace from "@/components/Header/HeaderComponents/HeaderWorkspace.vue";
import ProfileImage from "@/components/Profile/profile-images/ProfileImage.vue";
import HeaderStarredBoards from "@/components/Header/HeaderComponents/HeaderStarredBoards.vue";
import HeaderRecent from "@/components/Header/HeaderComponents/HeaderRecent.vue";

// Data
const dropdownOpen = ref(false)
const router = useRouter()
const showModal = ref(false)
const user = useUserStore()

// Methods
const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
}

const closeDropdown = () => {
  dropdownOpen.value = false;
}

const logoutUser = async () => {
  return await router.push('/logout')
}

const handleUpdateShow = (show) => {
  showModal.value = show
}

const showWorkspaceModal = () => {
  showModal.value = true
}

</script>

<template>
  <nav class="fixed z-40 w-full bg-white border border-b border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-2">
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-green-500">TaskCraft.io</span>
      </a>
      <button
        data-collapse-toggle="navbar-dropdown"
        type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-dropdown"
        aria-expanded="false"
      >
        <span class="sr-only">Open main menu</span>
        <svg
          class="w-5 h-5"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 17 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15"
          />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
        <ul
          class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-black-500 dark:border-gray-700"
        >
          <li>
            <HeaderWorkspace
              @show-modal="showWorkspaceModal"
              @hide-modal="handleUpdateShow(false)"
            />
          </li>
          <li class="relative" v-click-outside="closeDropdown">
            <HeaderRecent />
          </li>
          <li>
            <HeaderStarredBoards />
          </li>
          <li>
            <div class="flex items-center md:p-1">
              <div class="flex items-center">
                  <button
                    type="button"
                    class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    aria-expanded="false"
                    data-dropdown-toggle="dropdown-user"
                  >
                    <span class="sr-only">Open user menu</span>
                    <ProfileImage
                      :editable="false"
                      :size="'8'"
                    />
                  </button>
                  <div
                    class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="dropdown-user"
                  >
                    <div class="px-4 py-3" role="none">
                      <p class="text-sm text-gray-900 dark:text-white" role="none">
                        {{ user.name }}
                      </p>
                      <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                        {{ user.email }}
                      </p>
                    </div>
                    <ul class="py-1" role="none">
                      <li>
                        <router-link
                          :to="'/profile'"
                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500"
                          role="menuitem"
                        >
                          Profile
                        </router-link>
                      </li>
                      <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500" role="menuitem">
                          Activity
                        </a>
                      </li>
                      <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500" role="menuitem">
                          Settings
                        </a>
                      </li>
                      <li>
                        <a
                          @click="logoutUser()"
                          href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500" role="menuitem"
                        >
                          Sign out
                        </a>
                      </li>
                    </ul>
                  </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <CreateWorkspaceModal :show="showModal" @update:show="handleUpdateShow"/>
</template>

<style scoped>
/* Scoped styles for optional customizations */
</style>
