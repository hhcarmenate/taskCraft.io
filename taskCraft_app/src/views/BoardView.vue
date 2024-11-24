<script setup>
import BoardComponent from "@/components/Board/BoardComponent.vue"
import {useBoardStore} from "@/stores/useBoardStore.js"
import { ref, watch } from 'vue'
import {useRoute} from "vue-router"
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js"
import SolidStarIcon from "@/components/icon/SolidStarIcon.vue"
import OutlineStarIcon from "@/components/icon/OutlineStarIcon.vue"
import useNotification from "@/composables/useNotification.js"
import {useUserStore} from "@/stores/useUserStore.js"
import UpdateBoardModal from '@/components/modals/Board/UpdateBoardModal.vue'

// Composable and Stores
const board = useBoardStore()
const workspace = useWorkspaceStore()
const route = useRoute()
const { notify } = useNotification()
const user = useUserStore()
const showUpdateBoardModal = ref()

watch(
  () => workspace.currentWorkspace,
  () => {
        if (!board.title && route.params.id) {
          board.initCurrentBoardFromWorkspace(route.params.id)
        }
    },
  { immediate: true}
  )

const handleStarred = async(event) => {
  event.stopPropagation()

  try {
    const response = await board.toggleStarred(board.id, !board.starred)

    if (response.status === 200) {
      let message = board.starred
        ? 'Remove star successfully'
        : 'Board Starred Successfully!'
      board.starred = !board.starred
      notify('success', message)

      await workspace.fetchUserWorkspaces(user.userId)
    } else {
      let message = 'Oops! something went wrong!'
      message = response.error?.response?.data?.message ?? message

      notify('error', message)
    }
  } catch (err) {
    console.log(err)

    notify('error', 'Oops! something went wrong!')
  }
}

const openBoardOptions = () => {
  showUpdateBoardModal.value = true
}

</script>

<template>
  <section class="board-title font-thin text-2xl mb-3">
    <div class="board__title-section w-full flex flex-row justify-between">
      <div class="first-column flex flex-row justify-start items-center">
        <h1>Board | <span v-if="board.title">{{ `${board.title ?? ''}` }}</span></h1>
        <div
          class="icon-section hand"
          @click="handleStarred"
        >
          <SolidStarIcon v-if="board.starred" />
          <OutlineStarIcon v-else />
        </div>
      </div>
      <div class="second-column">
        <button
          @click="openBoardOptions()"
          class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
          type="button"
        >
          <span class="sr-only">Open dropdown</span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 3"
          >
            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
          </svg>
        </button>
      </div>
    </div>
  </section>
  <BoardComponent />
  <UpdateBoardModal
    :show="showUpdateBoardModal"
    @update:show="showUpdateBoardModal = false"
  />
</template>

<style scoped>
.board-title {
  display: flex;
  flex-direction: row;
  gap: 2px;
  align-items: center;
}
.hand {
  cursor: pointer;
}
</style>
