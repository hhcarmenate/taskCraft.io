<template>
  <div class="board-container flex flex-wrap gap-4 p-4 dark:bg-gray-700">
    <draggable
      v-model="lists"
      group="lists"
      class="flex gap-4 overflow-x-scroll"
      :options="{ animation: 200 }"
    >
      <template #item="{ element }">
        <div
          :key="element.id"
          class="board-list bg-white shadow-md rounded p-4 w-64 flex flex-col dark:bg-gray-800"
        >
          <h2 class="text-xl font-semibold mb-2">{{ element.title }}</h2>
          <draggable
            v-model="element.tasks"
            group="tasks"
            class="flex flex-col gap-2"
            :options="{ animation: 200 }"
          >
            <template #item="{ element: task }">
              <div
                :key="task.id"
                class="task bg-blue-100 p-2 rounded shadow dark:bg-gray-900"
              >
                {{ task.name }}
              </div>
            </template>
          </draggable>
          <button
            @click="addTask(element.id)"
            class="mt-2 bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600"
          >
            Add Task
          </button>
        </div>
      </template>
    </draggable>
  </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
  components: { draggable },
  data() {
    return {
      lists: [
        { id: 1, title: "To Do", tasks: [{ id: 1, name: "Task 1" }] },
        { id: 2, title: "In Progress", tasks: [{ id: 2, name: "Task 2" }] },
        { id: 3, title: "Done", tasks: [{ id: 3, name: "Task 3" }] },
      ],
    };
  },
  methods: {
    addTask(listId) {
      const list = this.lists.find((l) => l.id === listId);
      if (list) {
        list.tasks.push({ id: Date.now(), name: `New Task` });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.board-container {
  max-width: 100%;
  min-height: 95%;
  overflow-x: auto;

  .board-list {
    max-height: 98%;
    min-height: 200px;
  }

}

.task {
  cursor: grab;
}
</style>
