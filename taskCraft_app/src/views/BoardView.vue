<script setup>
import BoardComponent from "@/components/Board/BoardComponent.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import {watch} from "vue";
import {useRoute} from "vue-router";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import SolidStarIcon from "@/components/icon/SolidStarIcon.vue";
import OutlineStarIcon from "@/components/icon/OutlineStarIcon.vue";
import useNotification from "@/composables/useNotification.js";
import {useUserStore} from "@/stores/useUserStore.js";

// Composable and Stores
const board = useBoardStore()
const workspace = useWorkspaceStore()
const route = useRoute()
const { notify } = useNotification()
const user = useUserStore()


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
  event.stopPropagation();

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

</script>

<template>
  <section class="board-title font-thin text-2xl mb-3">
    <h1>Board <span v-if="board.title">{{ `${board.title ?? ''}` }}</span></h1>
    <div class="icon-section hand" @click="handleStarred">
      <SolidStarIcon v-if="board.starred" />
      <OutlineStarIcon v-else />
    </div>
  </section>
  <BoardComponent />
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
