<script setup>
import {computed, onMounted} from "vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {initDropdowns} from "flowbite";

const workspace = useWorkspaceStore()

onMounted(() => {
  initDropdowns()
})

const hasRecentBoards = computed(() => workspace.recentBoards.length)

const handleRedirectRecent = (recent) => {

}

</script>

<template>
  <div class="header__workspace-container">
    <button
      data-dropdown-toggle="dropdown-recent"
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
    <div
      class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
      id="dropdown-recent"
    >
      <div class="py-1" role="none" v-if="!hasRecentBoards" >
        <p
          class="px-4 py-2 flex flex-col text-sm text-gray-700 dark:text-white"
          role="none"
        >
          <span >No Recent Boards</span>
        </p>
      </div>
      <ul class="py-1" role="none" v-else>
        <li
          v-for="(recent, index) in workspace.recentBoards"
          :key="recent.id + ' ' + index"
          @click="handleRedirectRecent(recent)"
        >
          <a
            class="flex flex-col hand px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500"
            role="menuitem"
          >
            {{ recent.title }}
            <small v-if="recent.description">{{ recent.description }}</small>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
#dropdown-recent {
  min-width: 165px
}

.hand {
  cursor: pointer;
}
</style>
