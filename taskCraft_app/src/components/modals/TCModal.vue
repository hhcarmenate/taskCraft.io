<script setup>
import {computed, ref, watch} from "vue";
import {useOverlayStore} from "@/stores/useOverlayStore.js";
import TextInput from "@/components/fields/TextInput.vue";
import {Form} from "vee-validate";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from 'zod'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: 'Modal Title'
  },
  editableTitle: {
    type: Boolean,
    default: false
  },
  callBackEditableTitle: {
    type: Function,
    required: false
  },
  size: {
    type: String,
    required: false
  }
});

const overlay = useOverlayStore()
const showEditTitleInput = ref(false)
const newTitle = ref('')

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
        newTitle: zod.string({message: 'New Task Title is required'})
    })
  )
})

const modalSize = computed(() => {
  switch (props.size){
    case ('small'):
      return 'max-w-xl'
    case ('default'):
      return 'max-w-2xl'
    case ('large'):
      return 'max-w-4xl'
    case ('extra-large'):
      return 'max-w-6xl'
    default:
      return 'max-w-2xl'
  }
})


watch(() => props.show, (newValue) => {
  if (newValue) {
    overlay.showOverlay()
  } else {
    overlay.hideOverlay()
  }
})

const handleEditTitle = () => {
  if (props.editableTitle) {
    showEditTitleInput.value = true
    newTitle.value = props.title
  }
}

const onSubmit = () => {
  if (props.editableTitle) {
    props.callBackEditableTitle(newTitle.value)
    newTitle.value = ''
    showEditTitleInput.value = false
  }
}

const onInvalidSubmit = (error) => {
  console.log(error)
}

const cancelEditTitle = () => {
  newTitle.value = ''
  showEditTitleInput.value = false
}

</script>

<template>
  <div
    id="default-modal"
    tabindex="-1"
    class="fixed inset-0 z-100 flex items-center justify-center bg-black bg-opacity-50"
    :class="{'hidden': !show}"
  >
    <div class="relative p-4 w-full max-h-full"
      :class="modalSize"
    >
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3
            v-if="!showEditTitleInput"
            class="text-xl font-semibold text-gray-900 dark:text-white"
            @click="handleEditTitle"
            :class="{hand: editableTitle}"
          >
            {{ title }}
          </h3>
          <div v-else>
            <Form
              class="flex flex-row items-center gap-2"
              :validation-schema="validationSchema"
              @submit="onSubmit"
              @invalidSubmit="onInvalidSubmit"
            >
              <TextInput
                name="newTitle"
                placeholder="New Title"
                v-model="newTitle"
              />

              <button
                class="py-1 px-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none
                       bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                       hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                       dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                       dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                type="submit"
              >
                save
              </button>
              <button
                class="py-1 px-2 text-sm font-medium text-gray-900 focus:outline-none
                      bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                      hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                      dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-danger-400
                       dark:border-danger-600 dark:hover:text-danger-400
                       dark:hover:bg-gray-700"
                type="button"
                @click="cancelEditTitle"
              >
                Cancel
              </button>
            </Form>

          </div>
          <button @click="$emit('update:show', false)" type="button"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                  data-modal-hide="default-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <slot name="body"></slot>
        </div>
        <!-- Modal footer -->
        <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <slot name="footer">
            <button @click="$emit('update:show', false)" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              I accept
            </button>
            <button @click="$emit('update:show', false)" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
              Decline
            </button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.hand {
  cursor: pointer;
}
</style>
