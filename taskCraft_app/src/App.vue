<script setup>
import { ref, watch } from 'vue'
import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'
import listenChannels from '@/plugins/listenChannels.js'

const message = ref()
const workspace = useWorkspaceStore()
const { listenCurrentWorkspace } = listenChannels()

watch(() => workspace.currentWorkspace,  (newValue) => {
  if (newValue) {
    listenCurrentWorkspace(workspace.currentWorkspace.id)
  }
})

</script>

<template>
  <RouterView />
</template>
