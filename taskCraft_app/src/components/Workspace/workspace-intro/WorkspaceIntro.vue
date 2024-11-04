<script setup>
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import WorkspaceLogo from "@/components/Workspace/workspace-logo/WorkspaceLogo.vue";
import {reactive, ref} from "vue";
import useNotification from "@/composables/useNotification.js";
import {useUserStore} from "@/stores/useUserStore.js";
import TCIcon from "@/components/icon/TCIcon.vue";
import EditWorkspaceModal from "@/components/modals/Workspace/EditWorkspaceModal.vue";
import InviteMembers from "@/components/modals/Workspace/InviteMembers.vue";
import InviteMembersModal from "@/components/modals/Workspace/InviteMembersModal.vue";

const workspace = useWorkspaceStore()
const user = useUserStore()

const localState = reactive({
  updating: false,
})

const editWorkspaceModal = ref(false)
const inviteModal = ref(false)

const { notify } = useNotification()

const handleUpdateWorkspaceLogo = async (logo) => {
  try {
    localState.updating = true
    const response = await workspace.updateWorkSpaceLogo({
      file: logo
    })

    if (response.status === 200) {
      notify('success', 'Workspace logo updated successfully')

      await workspace.fetchUserWorkspaces(user.userId)
    } else {
      notify('error', 'Ops! something went wrong')
    }

  } catch (e) {
    console.error(e)

    notify('error', 'Ops! something went wrong')
  } finally {
    localState.updating = false
  }
}

const showEditWorkspaceModal = () => {
  editWorkspaceModal.value = true
}

const showInviteMembersModal = () => {
  inviteModal.value = true
}
</script>

<template>
  <div class="first__line w-full  flex flex-col justify-center items-center">
    <div class="w-3/4 flex flex-row justify-evenly items-center">
      <div class="flex flex-row px-4 py-5 gap-2 justify-start items-center">
        <div class="logo-container">
          <WorkspaceLogo
            :editable="false"
            @updated:logo="handleUpdateWorkspaceLogo"
          />
        </div>
        <div class="workspace__container ">
          <h4 class="text-2xl flex flex-row items-center gap-2">
            {{ workspace.currentWorkspace?.name }}
            <span
              class="edit-icon-container p-2 hover:bg-gray-900 rounded-md"
              @click="showEditWorkspaceModal"
            >
              <TCIcon hand :icon="'heroicons-outline:pencil'" />
            </span>
          </h4>
          <small>{{ workspace.currentWorkspace?.description }}</small>
        </div>
      </div>

      <div class="workspace__container px-4 py-5">
        <button
          type="button"
          class="py-1 px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
          @click="showInviteMembersModal"
        >
          Invite new member to this workspace
        </button>
      </div>
    </div>
    <div class="w-[85%] divider border-b border-solid border-gray-500"></div>
  </div>
  <EditWorkspaceModal :show="editWorkspaceModal" @update:show="editWorkspaceModal = false" />
  <InviteMembersModal :show="inviteModal" @update:show="inviteModal = false" />
</template>
