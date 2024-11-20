<script setup>
import { computed, onMounted, ref } from 'vue'
import { initDropdowns } from 'flowbite'
import { Form } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as zod from 'zod'
import TextareaInput from '@/components/fields/TextareaInput.vue'
import { useBoardStore } from '@/stores/useBoardStore.js'
import useNotification from '@/composables/useNotification.js'

const comment = ref('')
const board = useBoardStore()
const {notify} = useNotification()

onMounted(() => {
  initDropdowns()
})

const currentComments = computed(() => {
  return board.selectedTask?.comments ?? []
})

const validationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      comment: zod.string({message: 'Please write a comment!'})
    })
  )
})

const createComment = async () => {
  try {
    const response = await board.addComment(comment.value)

    if (response.status === 201) {
      board.selectedTask.comments.unshift(response.data.data)
      comment.value = ''
      notify('success', 'Comment added successfully')
      return
    }

    notify('error', 'Oops something went wrong!')
  } catch (e) {
    console.log(e)

    notify('error', 'Oops something went wrong!')
  }
}

</script>

<template>
  <section class="py-4 lg:py-4 antialiased">
    <div class="max-w-2xl mx-auto px-4">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion <span v-if="currentComments.length">({{ currentComments.length }})</span></h2>
      </div>
      <Form
        class="mb-6"
        :validation-schema="validationSchema"
        :submit="createComment"
      >
        <TextareaInput
          name="comment"
          v-model="comment"
          placeholder="Write a comment..."
          id="comment_textarea"
          show-error
        />
        <button
          type="submit"
          class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center mt-2
                          text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200
                          dark:focus:ring-success-900 hover:bg-success-800 dark:bg-success-600"
        >
          Post comment
        </button>
      </Form>
      <div
        v-if="currentComments.length"
        class="comments-section"
      >
        <article
          v-for="com in currentComments"
          class="p-6 text-base bg-white rounded-lg dark:bg-gray-900 mt-2"
          :key="com.id"
        >
          <footer class="flex justify-between items-center mb-2">
            <div class="flex items-center">
              <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                <img
                  class="mr-2 w-6 h-6 rounded-full"
                  :src="com.profilePicture"
                  alt="Michael Gough"
                />{{ com.createdBy.name }}
              </p>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <time
                  :datetime="com.createdAt"
                  :title="com.createdAt"
                >
                  {{ com.createdAt }}
                </time>
              </p>
            </div>
          </footer>
          <p class="text-gray-500 dark:text-gray-400">
            {{ com.comment }}
          </p>
        </article>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>
