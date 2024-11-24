<script setup>
import { watch } from 'vue'
import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'
import listenChannels from '@/plugins/listenChannels.js'
import { useBoardStore } from '@/stores/useBoardStore.js'

const workspace = useWorkspaceStore()
const board = useBoardStore()
const { listenCurrentWorkspace, listenBoard } = listenChannels()

watch(() => workspace.currentWorkspace,  (newValue) => {
  if (newValue) {
    listenCurrentWorkspace(workspace.currentWorkspace.id)
  }
})

watch(() => board.id, (newValue) => {
  if (newValue) {
    listenBoard(newValue)
  }
})

</script>

<template>
  <RouterView />
</template>
