<script setup>
import {computed, onMounted, ref} from "vue"
import TextInput from "@/components/fields/TextInput.vue"
import {Form} from "vee-validate"
import * as zod from 'zod'
import {toTypedSchema} from "@vee-validate/zod"
import {useBoardStore} from "@/stores/useBoardStore.js"
import useNotification from "@/composables/useNotification.js"

const props = defineProps({
  listElement: {
    type: Object,
    required: true
  }
})
const editing = ref(false)
const newListTitle = ref()
const board = useBoardStore()
const { notify } = useNotification()

// Computed
const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      newListTitle: zod
        .string({message: 'List title is required'})
        .min(3, {message: 'List title must be at least 3 characters log'})
    })
  )
})

onMounted(() => {
  newListTitle.value = props.listElement.title
})

const handleEdit = () => {
  editing.value = true
}

const cancelAddList = () => {
  editing.value = false
}

const onSubmit = async () => {
  try {
    const response = await board.updateListName({
      listId: props.listElement.id,
      newListTitle: newListTitle.value
    })

    if (response.status === 200) {
      board.lists.forEach((list) => {
        if (props.listElement.id === list.id) {
          list.title = newListTitle.value
        }
      })

      editing.value = false

      notify('success', 'Board List title updated successfully')
    } else {
      notify('error', 'Oops something went wrong!')
    }

  } catch (e) {
    console.log(e)

    notify('error', 'Oops something went wrong!')
  }
}

const onInvalidSubmit = () => {

}

</script>

<template>
  <div class="board-intro">
    <h2
      v-if="!editing"
      class="board-title text-xl font-semibold mb-2 hand"
      @click="handleEdit"
    >
      {{ listElement.title }}
    </h2>
    <div v-if="editing">
      <Form
        :validation-schema="validationSchema"
        @submit="onSubmit"
        @invalid-submit="onInvalidSubmit"
      >
        <TextInput
          name="newListTitle"
          show-error
          v-model="newListTitle"
          placeholder="List Title"
        />
        <div class="flex flex-row gap-2">
          <button
            type="submit"
            class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
          >
            Add
          </button>
          <button
            type="button"
            @click="cancelAddList"
            class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-danger-400
                dark:border-danger-600 dark:hover:text-danger-400 dark:hover:bg-gray-700"
          >
            Cancel
          </button>
        </div>
      </Form>
    </div>
  </div>
</template>

<style scoped>
.hand {
  cursor: pointer;
}

.board-intro {
  display: flex;
  flex-direction: row;
}

.board-title {
  display: inline-flex;
}
</style>
