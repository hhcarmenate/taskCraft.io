<script setup>
import BoardComponent from "@/components/Board/BoardComponent.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import {onMounted} from "vue";
import {initFlowbite} from "flowbite";
import {useRoute} from "vue-router";
const board = useBoardStore()
const route = useRoute()

onMounted(() => {
  initFlowbite()

  if (!board.title && route.params.id) {
    board.initCurrentBoardFromWorkspace(route.params.id)
  }
})

</script>

<template>
  <section class="title font-thin text-2xl">
    <h1>Board <span v-if="board.title">{{ `${board.title ?? ''}` }}</span></h1>
  </section>
  <BoardComponent />
</template>

<style scoped>

</style>
