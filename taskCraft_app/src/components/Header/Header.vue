<script setup>
import { ref } from "vue"
import {useRouter} from "vue-router";
import CreateWorkspaceModal from "@/components/modals/CreateWorkspaceModal.vue";
import {useUserStore} from "@/stores/useUserStore.js";
import HeaderWorkspace from "@/components/Header/HeaderComponents/HeaderWorkspace.vue";

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
  return await router.push('logout')
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
            <HeaderWorkspace />
          </li>
          <li>
            <a

              @click="showWorkspaceModal"
              class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:p-1 dark:bg-blue-600 md:dark:bg-transparent dark:hover:bg-gray-700 dark:hover:text-green-500"
              aria-current="page"
            >
              Workspaces
            </a>
          </li>
          <li class="relative" v-click-outside="closeDropdown">
            <button
              @click="toggleDropdown"
              id="dropdownNavbarLink"
              class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-info-700 md:p-1 md:w-auto dark:text-white md:dark:hover:bg-gray-700 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-gray-700 dark:hover:text-green-500"
            >
              Recent
              <svg
                class="w-2.5 h-2.5 ms-2.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 10 6"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m1 1 4 4 4-4"
                />
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div
              id="dropdownNavbar"
              :class="{ hidden: !dropdownOpen }"
              class="absolute right-0 z-10 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-gray-800 ring-opacity-5 dark:bg-gray-700 dark:divide-gray-600"
              role="menu"
              aria-orientation="vertical"
              aria-labelledby="dropdownNavbarLink"
            >
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-green-500">
                    Dashboard
                  </a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-green-500">
                    Settings
                  </a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-green-500">
                    Earnings
                  </a>
                </li>
              </ul>
              <div class="py-1">
                <a
                  href="#"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-green-500"
                >
                  Sign out
                </a>
              </div>
            </div>
          </li>
          <li>
            <a
              href="#"
              class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-info-700 md:p-1 dark:text-white md:dark:hover:bg-gray-700 dark:hover:bg-gray-700 dark:hover:text-green-500 md:dark:hover:bg-gray-700"
            >
              Starred
            </a>
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
                    <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
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
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500" role="menuitem">
                          Profile
                        </a>
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
