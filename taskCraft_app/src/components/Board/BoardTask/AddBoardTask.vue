<script setup>
import TextareaInput from "@/components/fields/TextareaInput.vue";
import {computed, ref} from "vue";
import {Form} from "vee-validate";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";
import useNotification from "@/composables/useNotification.js";
import {useBoardStore} from "@/stores/useBoardStore.js";

const emit = defineEmits(['update:cancel', 'update:new'])
const props = defineProps({
  boardList: {
    type: Object,
    default: true
  }
})

const taskTitle = ref()
const { notify } = useNotification()
const board = useBoardStore()

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      taskTitle: zod.string({message: 'Task title is required'})
        .min(5,{message: 'Task should have at least 5 characters long'})
    })
  )
})

const onSubmit = async () => {
  try {
    const response = await board.addTaskToBoardList({
      boardListId: props.boardList.id,
      taskTitle: taskTitle.value
    })

    if (response.status >= 200 && response.status < 300) {
      const { data } = response.data

      const currentList = board.lists.find((selectedList) => selectedList.id === props.boardList.id)

      if (currentList) {
        currentList.tasks.push(data)
      }

      emit('update:cancel')
    } else {
      notify('error', 'Oops something went wrong!')
    }

  } catch (e) {
    console.log(e)

    notify('error', 'Oops something went wrong!')
  }
}

const onInvalidSubmit = (error) => {
  console.log(error)
}

const cancelAddTask = () => {
  emit('update:cancel')
}

</script>

<template>
  <div class="flex flex-col">
    <Form
      :validation-schema="validationSchema"
      @submit="onSubmit"
      @invalid-submit="onInvalidSubmit"
    >
      <TextareaInput
        name="taskTitle"
        show-error
        v-model="taskTitle"
        placeholder="Task Title"
      />
      <div class="flex flex-row gap-2">
        <button
          type="submit"
          class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                  bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                  hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                  dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                  dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
          Add
        </button>
        <button
          type="button"
          @click="cancelAddTask"
          class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                  bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                  hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                  dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-danger-400
                  dark:border-danger-600 dark:hover:text-danger-400 dark:hover:bg-gray-700">
          Cancel
        </button>
      </div>
    </Form>

  </div>
</template>

<style scoped>

</style>
