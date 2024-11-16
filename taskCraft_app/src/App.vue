<script setup>
import { onMounted, ref } from 'vue'

const message = ref()

onMounted(() => {
  listenForBroadcast()
})

const listenForBroadcast = () => {
  window.Echo.channel('test-channel')
    .listen('TestBroadcast', (e) => {
      message.value = e.message
      console.log('Event received: ', e)
    })
}

</script>

<template>
  <RouterView />
</template>
