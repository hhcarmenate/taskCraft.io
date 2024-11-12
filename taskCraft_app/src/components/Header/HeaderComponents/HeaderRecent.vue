<script setup>
import {computed, onMounted, ref} from "vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {useBoardStore} from "@/stores/useBoardStore.js";
import {useRouter} from "vue-router";

const workspace = useWorkspaceStore()
const board = useBoardStore()
const dropdownRecent = ref(false)
const router = useRouter()

const dropdownClasses = computed(() => {
  return (dropdownRecent.value) ? 'dropdown-open' : 'hidden'
})

const hasRecentBoards = computed(() => workspace.recentBoards.length)

const handleRedirectRecent = async (recent) => {
  dropdownRecent.value = false
  workspace.setCurrentWorkSpace(workspace.workspaces.find(work => work.id === recent.id))
  board.initCurrentBoard(recent)

  return await router.push(`/board/${recent.id}`)
}

const closeDropdown = () => {
  dropdownRecent.value = false
}

const toggleDropdownRecent = () => {
  dropdownRecent.value = !dropdownRecent.value
}

</script>

<template>
  <div
    class="header__workspace-container"
    v-click-outside="closeDropdown"
  >
    <button
      @click="toggleDropdownRecent"
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
      class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
      :class="dropdownClasses"
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

.hand {
  cursor: pointer;
}

.dropdown-open {
  min-width: 165px;
  position: absolute;
  margin: 0;
  transform: translate(-30px, 8px);
}


</style>
