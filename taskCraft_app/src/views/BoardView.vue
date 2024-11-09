<script setup>
import BoardComponent from "@/components/Board/BoardComponent.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import {onMounted, watch} from "vue";
import {initFlowbite} from "flowbite";
import {useRoute} from "vue-router";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

// Composable and Stores
const board = useBoardStore()
const workspace = useWorkspaceStore()
const route = useRoute()

onMounted(() => {
  initFlowbite()
})

watch(
  () => workspace.currentWorkspace,
  () => {
        if (!board.title && route.params.id) {
          board.initCurrentBoardFromWorkspace(route.params.id)
        }
    },
  { immediate: true}
  )

</script>

<template>
  <section class="title font-thin text-2xl">
    <h1>Board <span v-if="board.title">{{ `${board.title ?? ''}` }}</span></h1>
  </section>
  <BoardComponent />
</template>

<style scoped>

</style>
