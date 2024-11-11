<script setup>
import {computed, ref} from "vue";
import OutlineStarIcon from "@/components/icon/OutlineStarIcon.vue";
import {useBoardStore} from "@/stores/useBoardStore.js";
import useNotification from "@/composables/useNotification.js";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {useUserStore} from "@/stores/useUserStore.js";
import SolidStarIcon from "@/components/icon/SolidStarIcon.vue";
import {useRouter} from "vue-router";

const props = defineProps({
  workspaceBoard: {
    type: Object,
    required: true
  },
  index: {
    type: Number,
    required: true
  }
})

const isHovered = ref(false);
const board = useBoardStore()
const { notify } = useNotification()
const workspace = useWorkspaceStore()
const user = useUserStore()
const router = useRouter()

const bgComputed = computed(() => {
  let sum = props.index * 100 + 100
  return `bg-blue-${sum} ${ sum > 500 ? 'text-white' : 'text-black-800' }`
})

const handleMouseEnter = () => isHovered.value = true;
const handleMouseLeave = () => isHovered.value = false;

const toggleStarred = async () => {
  try {
    const response = await board.toggleStarred(props.workspaceBoard.id, !props.workspaceBoard.starred)

    if (response.status === 200) {
      let message = props.workspaceBoard.starred
        ? 'Remove star successfully'
        : 'Board Starred Successfully!'

      notify('success', message)

      await workspace.fetchUserWorkspaces(user.userId)
    } else {
      let message = 'Oops! something went wrong!'
      message = response.error?.response?.data?.message ?? message

      notify('error', message)
    }
  } catch (err) {
    console.log(err)

    notify('error', 'Oops! something went wrong!')
  }
}

const handleBoardClick = async () => {
  board.initCurrentBoard(props.workspaceBoard)

  return await router.push(`/board/${props.workspaceBoard.id}`)
}

</script>

<template>
  <div class="board-container">
    <div
      class="board-card rounded rounded-4 px-2 py-1 hand font-semibold"
      :class="bgComputed"
      @mouseenter="handleMouseEnter"
      @mouseleave="handleMouseLeave"
      @click="handleBoardClick()"
    >
      {{ workspaceBoard.title }}
    </div>
    <SolidStarIcon
      v-if="workspaceBoard.starred"
      class="star-icon"
      @click="toggleStarred"
    />

    <OutlineStarIcon
      v-if="!workspaceBoard.starred && isHovered"
      class="star-icon"
      @click="toggleStarred"
    />
  </div>


</template>

<style scoped>
.hand {
  cursor: pointer;
}

.board-container {
  position: relative
}

.board-card {
  min-height: 80px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.star-icon {
  position: absolute;
  bottom: 8px;
  right: 8px;
}
</style>
