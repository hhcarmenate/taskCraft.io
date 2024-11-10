<template>
  <div class="board-container flex flex-nowrap gap-4 p-4 dark:bg-gray-700  overflow-x-scroll">
    <draggable
      v-model="board.lists"
      group="lists"
      class="flex gap-4 min-h-[95%]"
      :options="{ animation: 200 }"
      item-key="id"
    >
      <template #item="{ element }">
        <BoardList
          :list-element="element"
          :key="element.id"
          @add:task="handleAddTask"
        />
      </template>
    </draggable>
    <AddBoardList
      @update:new-list="handleAddNewList"
    />
  </div>
</template>

<script setup>
import draggable from "vuedraggable";
import BoardList from "@/components/Board/BoardTask/BoardList.vue";
import AddBoardList from "@/components/Board/BoardTask/AddBoardList.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import {watch} from "vue";
import useNotification from "@/composables/useNotification.js";

// Data
const board = useBoardStore()
const {notify} = useNotification()

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

const updatePosition = async (positions) => {
  console.log('new positions', positions)
  try {
    await board.updateListsPositions(positions)
  } catch(e) {
    console.log(e)
    notify('error', 'Oops, something went wrong')
  }
}

// Observers
watch(() => board.lists, (newList) => {
  if (newList) {
    let newPositions = []

    newPositions = newList.map((list, index) => {
      return { position: index + 1, id: list.id }
    })

    updatePosition(newPositions)
  }
}, {immediate: true})

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
