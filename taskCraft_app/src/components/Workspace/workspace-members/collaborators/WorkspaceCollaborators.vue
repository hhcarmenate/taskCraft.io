<script setup>
import {computed, ref} from "vue";
import TextInput from "@/components/fields/TextInput.vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

const workspace = useWorkspaceStore()
const typeSelected = ref('workspace')

const selectType = (type) => {
  typeSelected.value = type
}

const workspaceMembers = computed(() => {
  return workspace.currentWorkspace?.members ?? []
})

const workspaceGuests = computed(() => {
  return workspace.currentWorkspace?.guests ?? []
})

</script>

<template>
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-4 px-2 border-r border-solid border-gray-500">
      <div
        class="p-2 mt-2 flex flex-row rounded justify-between items-center hand hover:bg-gray-700"
        @click="selectType('workspace')"
        :class="{'bg-gray-900': typeSelected === 'workspace'}"
      >
        <p>Workspace Members</p>
        <span>({{ workspaceMembers.length }}/10)</span>
      </div>
      <div
        class="p-2 mt-2 flex flex-row rounded justify-between items-center hand hover:bg-gray-700"
        @click="selectType('guest')"
        :class="{'bg-gray-900': typeSelected === 'guest'}"
      >
        <p>Guest</p>
        <span>({{ workspaceGuests.length }}/10)</span>
      </div>
    </div>
    <div class="col-span-8" v-if="typeSelected === 'workspace'">
      <div class="pb-6 text-sm border-b border-gray-500">
        <p>
          Workspace members can view and join all Workspace visible boards and create new boards in the Workspace.
        </p>
      </div>
      <div class="pb-6 text-sm border-b border-gray-500 mt-5">
        <h3 class="text-xl mb-2">Invite New Members</h3>
        <div class="flex flex-row gap-4 justify-between items-center">
          <p class="w-[65%]">
            Anyone with an invite link can join this free Workspace. You can also disable and create a new invite link for this Workspace at any time. Pending invitations count toward the 10 collaborator limit.
          </p>
          <div class="w-[35%] flex flex-row justify-end">
            <button class="px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
              Link
            </button>
          </div>
        </div>
      </div>

      <div
        class="pb-6 text-sm mt-5"
        v-if="workspaceMembers.length"
      >
        <div class="mb-2">
          <TextInput
            placeholder="Filter by name"
          />
        </div>
        <div class="flex flex-row gap-4 justify-between items-center" >
          <ul class="w-full">
            <li>
              <div class="border-y border-solid border-gray-500 flex flex-row justify-between items-center px-1 py-2">
                <div class="member-name">
                  Henry Carmenate
                </div>
                <div class="actions">
                  <button
                    class="px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none
                    bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700
                    focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700
                    dark:bg-danger-800 dark:text-gray-400 dark:border-danger-800 dark:hover:text-white dark:hover:bg-danger-700"
                  >
                    Leave
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="pb-6 text-sm mt-5"
        v-else
      >
        There is no members in this workspace yet!
      </div>
    </div>
    <div class="col-span-8" v-if="typeSelected === 'guest'">
      <div class="pb-6 text-sm mt-5" v-if="workspaceGuests.length">
        <h3 class="text-xl mb-2">Guests</h3>
        <div class="mb-2">
          <TextInput
            placeholder="Filter by name"
          />
        </div>
        <div class="flex flex-row gap-4 justify-between items-center">
          <ul class="w-full">
            <li>
              <div class="border-y border-solid border-gray-500 flex flex-row justify-between items-center px-1 py-2">
                <div class="member-name">
                  Henry Carmenate
                </div>
                <div class="actions">
                  <button
                    class="px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none
                    bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700
                    focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700
                    dark:bg-danger-800 dark:text-gray-400 dark:border-danger-800 dark:hover:text-white dark:hover:bg-danger-700"
                  >
                    Leave
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="pb-6 text-sm mt-5"
        v-else
      >
        There is no guests in this workspace yet!
      </div>
    </div>
  </div>
</template>

<style scoped>
.hand {
  cursor: pointer;
}
</style>
