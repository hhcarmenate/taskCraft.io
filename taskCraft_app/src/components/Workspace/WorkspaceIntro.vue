<script setup>
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
const workspace = useWorkspaceStore()


</script>

<template>
  <div class="first__line w-full  flex flex-col justify-center items-center">
    <div class="w-3/4 flex flex-row justify-evenly items-center">
      <div class="workspace__container px-4 py-5">
        <h4 class="text-2xl">{{ workspace.currentWorkspace?.name }}</h4>
        <small>{{ workspace.currentWorkspace?.description }}</small>
      </div>
      <div class="workspace__container px-4 py-5">
        <button
          type="button"
          class="py-1 px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
        >
          Invite new member to this workspace
        </button>
      </div>
    </div>
    <div class="w-[85%] divider border-b border-solid border-gray-500"></div>
  </div>
</template>

<style scoped>

</style>
