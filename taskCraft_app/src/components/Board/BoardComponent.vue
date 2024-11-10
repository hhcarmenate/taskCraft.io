<template>
  <div class="board-container flex flex-nowrap gap-4 p-4 dark:bg-gray-700  overflow-x-scroll">
    <draggable
      v-model="lists"
      group="lists"
      class="flex gap-4"
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

<script>
import draggable from "vuedraggable";
import BoardList from "@/components/Board/BoardTask/BoardList.vue";
import AddBoardList from "@/components/Board/BoardTask/AddBoardList.vue";

export default {
  components: {AddBoardList, BoardList, draggable },
  data() {
    return {
      lists: [
        { id: 1, title: "To Do", tasks: [{ id: 1, name: "Task 1" }] },
        { id: 2, title: "In Progress", tasks: [{ id: 2, name: "Task 2" }] },
        { id: 3, title: "Done", tasks: [{ id: 3, name: "Task 3" }] },
      ],
      addingTask: false
    };
  },
  methods: {
    handleAddTask(data) {
      this.lists.forEach((list) => {
        if (list.id === data.id) {
          const index = list.tasks.length + 1
          list.tasks.push({ id: index, name: data.title })
        }
      })


      console.log('add data', data)
    },
    handleAddNewList(listName) {
      this.lists.push({
        id: this.lists.length + 1,
        title: listName,
        tasks: []
      })
    }
  },
};
</script>

<style lang="scss" scoped>
.board-container {
  width: 100%;
  min-height: 95%;
}

.board-list {
  min-height: 200px;
}

.task {
  cursor: grab;
}
</style>
