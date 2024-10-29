<script setup>

</script>

<template>
  <button
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
    <ul class="py-1" role="none">
      <li>
        <a
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-green-500"
          role="menuitem"
        >
          Profile
        </a>
      </li>
    </ul>
    <div class="px-4 py-3" role="none">
      <p class="text-sm text-gray-900 dark:text-white" role="none">
        Add New Workspace
      </p>
    </div>
  </div>
</template>

<style scoped>
#dropdown-workspace {
  min-width: 150px
}
</style>
