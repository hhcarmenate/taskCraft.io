<script setup>
import {computed, ref} from "vue";
import {Form} from "vee-validate";
import TextInput from "@/components/fields/TextInput.vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from 'zod'
import useNotification from "@/composables/useNotification.js";

// Emits
const emit = defineEmits(['update:newList'])

// Data
const addingList = ref(false)
const listName = ref('')
const sending = ref(false)
const { notify } = useNotification()

// Computed
const validationSchema = computed(() => {
 return toTypedSchema(
   zod.object({
     listName: zod
       .string({message: 'List name is required'})
       .min(3, {message: 'List name must be at least 3 characters log'})
   })
 )
})

// Methods
const cancelAddList = () => {
 addingList.value = false
}

const showAddList = () => {
 addingList.value = true
}

const onSubmit = async () => {
  try {
    sending.value = true
    const response = await ListService.createList()


  } catch(e) {
    console.log(e)

    notify('error', 'Oops something went wrong!')
  } finally {
    sending.value = false
  }
  emit('update:newList', listName.value)
  addingList.value = false
}

const onInvalidSubmit = () => {

}

</script>

<template>
      <div
        class="board-list bg-white shadow-md rounded p-4 min-w-64 flex flex-col dark:bg-gray-800"
      >
        <button
          @click="showAddList"
          v-if="!addingList"
          class="py-1 px-2 mt-2 text-sm font-medium text-gray-900 focus:outline-none
                  bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                  hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                  dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                  dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
        >
         + Add List
        </button>
        <div v-else>
          <Form
            :validation-schema="validationSchema"
            @submit="onSubmit"
            @invalid-submit="onInvalidSubmit"
          >
            <TextInput
              name="listName"
              show-error
              v-model="listName"
              placeholder="List Name"
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
                @click="cancelAddList"
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
      </div>
</template>

<style scoped>

</style>
