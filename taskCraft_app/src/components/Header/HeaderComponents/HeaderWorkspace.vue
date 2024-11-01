<script setup>
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {computed} from "vue";
import {useRouter} from "vue-router";

const emit = defineEmits(['showModal', 'hideModal'])

// Data
const workspace = useWorkspaceStore()
const hasWorkspace = computed(() => workspace.workspaces.length)
const router = useRouter()

// Methods
const handleWorkspaceModal = () => {
  emit('showModal')
}

const handleChangeWorkSpace = async (work) => {
  workspace.setCurrentWorkSpace(work)

  return await router.push(`/workspace/${workspace.currentWorkspace?.name}`)
}

</script>

<template>
  <div class="header__workspace-container">
    <a
      v-if="!hasWorkspace"
      @click="handleWorkspaceModal"
      class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:p-1 dark:bg-blue-600 md:dark:bg-transparent dark:hover:bg-gray-700 dark:hover:text-green-500"
      aria-current="page"
    >
      Workspaces
    </a>
    <button
      v-else
      data-dropdown-toggle="dropdown-workspace"
      id="dropdownNavbarLink"
      class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-info-700 md:p-1 md:w-auto dark:text-white md:dark:hover:bg-gray-700 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-gray-700 dark:hover:text-green-500"
    >
      Workspaces
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
      class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
      id="dropdown-workspace"
    >
      <div class="py-1" role="none" v-if="workspace.currentWorkspace">
        <p
          class="px-4 py-2 flex flex-col text-sm text-gray-700 dark:text-white"
          role="none"
        >
          <small class="mb-3">Current Workspace</small>
          {{ workspace.currentWorkspace.name ?? '' }}
          <small>{{ workspace.currentWorkspace.description }}</small>
        </p>
      </div>
      <ul class="py-1" role="none">
        <li
          v-for="work in workspace.workspaces"
          :key="work.id"
          @click="handleChangeWorkSpace(work)"
        >
          <a
            class="flex flex-col hand px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500"
            role="menuitem"
          >
            {{ work.name }}
            <small>{{ work.description }}</small>
          </a>
        </li>
      </ul>
      <div class="py-1" role="none">
        <p
          @click="handleWorkspaceModal"
          class="px-4 py-2 hand text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-green-500"
          role="none"
        >
          Add New Workspace
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
#dropdown-workspace {
  min-width: 150px
}

.hand {
  cursor: pointer;
}
</style>
