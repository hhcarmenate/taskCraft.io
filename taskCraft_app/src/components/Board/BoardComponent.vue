<template>
  <div
    class="board-container flex flex-nowrap gap-4 p-4 dark:bg-gray-700  overflow-x-scroll"
  >
    <div
      v-for="list in board.lists"
      class="flex gap-4 min-h-[95%]"
      :key="list.id"
    >
      <BoardList
        :list-element="list"
        @add:task="handleAddTask"
      />
    </div>
    <AddBoardList
      @update:new-list="handleAddNewList"
    />
  </div>
</template>

<script setup>
import BoardList from "@/components/Board/BoardTask/BoardList.vue"
import AddBoardList from "@/components/Board/BoardTask/AddBoardList.vue"
import {useBoardStore} from "@/stores/useBoardStore.js"

// Data
const board = useBoardStore()

// Methods
const handleAddTask = (data) => {
  board.lists.forEach((list) => {
    if (list.id === data.id) {
      const index = list.tasks.length + 1
      list.tasks.push({ id: index, name: data.title })
    }
  })
}

const handleAddNewList = (listName) => {
  board.lists.push({
    id: board.lists.length + 1,
    title: listName,
    tasks: []
  })
}


</script>

<style lang="scss" scoped>
.board-container {
  width: 100%;
  min-height: 95%;
}

.board-list {
  min-height: 95%;
}

.task {
  cursor: grab;
}
</style>
