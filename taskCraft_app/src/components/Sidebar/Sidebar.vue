<script setup>

import TCIcon from "@/components/icon/TCIcon.vue";
</script>

<template>
  <aside id="default-sidebar" class="fixed top-0 left-0 z-30 w-64 pt-14 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <ul class="space-y-2">
        <li>
          <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-green-500 group">
            <TCIcon :icon="'heroicons-outline:clipboard-document-list'" hand />
            <span class="ml-3">Boards</span>
          </a>
        </li>
        <li>
          <a type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-green-500" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
            <TCIcon :icon="'heroicons-outline:user'" hand />
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Members</span>
            <TCIcon :icon="'heroicons-outline:plus'" hand />
          </a>
        </li>
        <li>
          <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-green-500" aria-controls="dropdown-sales" data-collapse-toggle="dropdown-sales">
            <TCIcon :icon="'heroicons-outline:cog-8-tooth'" hand />
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Workspace Settings</span>
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
          <ul id="dropdown-sales" class="hidden py-2 space-y-2">
            <li>
              <a
                href="#"
                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-green-500"
              >
                Workspace Settings
              </a>
            </li>
            <li>
              <a
                href="#"
                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-green-500"
              >
                Upgrade Workspace
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
        <li>
          <p>Workspace Views</p>
        </li>
        <li>
          <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <TCIcon :icon="'heroicons-outline:table-cells'" hand />
            <span class="ml-3">Table</span>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <TCIcon :icon="'heroicons-outline:calendar-days'" hand />
            <span class="ml-3">Calendar</span>
          </a>
        </li>
      </ul>
      <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
        <li class="flex flex-row justify-between items-center">
          <p>Your boards</p>
          <TCIcon :icon="'heroicons-outline:plus'" hand />
        </li>
      </ul>

    </div>
    <div class="absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
      <a href="#" class="inline-flex justify-center p-2 text-xs text-gray-500 rounded cursor-pointer dark:text-gray-600 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
        Version 0.01
      </a>
    </div>
  </aside>
</template>

<style scoped>

</style>
