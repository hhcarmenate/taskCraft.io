<script setup>
import { computed, onMounted, ref } from 'vue'
import { initDropdowns } from 'flowbite'
import { Form } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as zod from 'zod'
import TextareaInput from '@/components/fields/TextareaInput.vue'
import { useBoardStore } from '@/stores/useBoardStore.js'
import useNotification from '@/composables/useNotification.js'
import ListService from '@/services/ListService.js'

const comment = ref('')
const board = useBoardStore()
const {notify} = useNotification()
const activeView = ref('comments')
const taskLogs = ref([])
const loadingTaskLogs = ref(false)

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

const handleActiveView = async (view) =>{
  activeView.value = view
  if (view === 'activities') {
    await loadTaskActivities()
  }
}

const loadTaskActivities = async () => {
  try {
    loadingTaskLogs.value = true

    const response = await ListService.loadTaskLogs(board.selectedTask.id)

    if (response.status === 200) {
      taskLogs.value = response.data
    } else {
      notify('error', 'Oops something went wrong!')
    }
  } catch (e) {
    console.log(e)

    notify('error', 'Oops something went wrong!')
  } finally {
    loadingTaskLogs.value = false
  }
}

</script>

<template>
  <section class="py-4 lg:py-4 antialiased">
    <div class="max-w-2xl mx-auto px-4">
      <div class="flex justify-between items-center mb-6">
        <h2
          class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white cursor-pointer"
          @click="handleActiveView('comments')"
        >
          Discussion <span v-if="currentComments.length">({{ currentComments.length }})</span>
        </h2>
        <h2
          class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white cursor-pointer"
          @click="handleActiveView('activities')"
        >
          Activity
        </h2>
      </div>
      <div
        class="comments-container"
        v-if="activeView === 'comments'"
      >
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
      <div
        class="activity-container"
        v-if="activeView === 'activities'"
      >
        <div
          class="-my-6"
          v-if="taskLogs.length"
        >
          <div
            v-for="log in taskLogs"
            class="relative pl-32 sm:pl-32 py-6 group"
          >
            <!-- Purple label -->
            <div class="font-caveat font-extralight text-xl text-white mb-1 sm:mb-0">
              {{ log.action }}
            </div>
            <!-- Vertical line (::before) ~ Date ~ Title ~ Circle marker (::after) -->
            <div class="flex flex-col sm:flex-row items-start mb-1 group-last:before:hidden before:absolute before:left-2 sm:before:left-0 before:h-full before:px-px before:bg-slate-300 sm:before:ml-[6.5rem] before:self-start before:-translate-x-1/2 before:translate-y-3 after:absolute after:left-2 sm:after:left-0 after:w-2 after:h-2 after:bg-indigo-600 after:border-4 after:box-content after:border-slate-50 after:rounded-full sm:after:ml-[6.5rem] after:-translate-x-1/2 after:translate-y-1.5">
              <time
                class="sm:absolute left-0 translate-y-0.5 inline-flex items-center justify-center text-xxs font-semibold
                uppercase w-20 h-6 mb-3 sm:mb-0 text-emerald-600 bg-emerald-100 rounded-full"
              >
                {{ log.date }}
              </time>
            </div>
            <!-- Content -->
            <div class="text-slate-500">{{ log.details }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.text-xxs {
  font-size:0.5rem;
}
</style>
