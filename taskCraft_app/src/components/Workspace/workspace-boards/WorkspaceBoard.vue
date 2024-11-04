<script setup>
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {computed, ref} from "vue";
import BoardCard from "@/components/Workspace/workspace-boards/board-card/BoardCard.vue";
import CreateBoardModal from "@/components/modals/Board/CreateBoardModal.vue";

const workspace = useWorkspaceStore()
const showCreateBoard = ref(false)

const boards = computed(() => {
  return workspace.currentWorkspace?.boards ?? []
})

const showCreateBoardModal = () => {
  showCreateBoard.value = true
}
</script>

<template>
  <div class="w-[85%] flex flex-col mt-6">
    <div class="grid grid-cols-4 gap-4">
      <!-- Replace the divs below with your actual content/components -->
      <div
        @click="showCreateBoardModal"
        class="bg-secondary-700 rounded rounded-4 p-6 hand"
      >
        Create New Board
      </div>

      <BoardCard
        v-if="boards.length"
        v-for="board in boards"
        :key="board"
        :board="board"
      />
    </div>
    <div class="board-image flex justify-center items-center mt-3">
      <div class="image-container w-[60%]">
        <img src="/images/boards.svg" alt="">
      </div>
    </div>
  </div>
  <CreateBoardModal :show="showCreateBoard" @update:show="showCreateBoard = false" />
</template>

<style scoped>
.hand {
  cursor: pointer;
}
</style>
