<script setup>
import {computed} from 'vue';
import {useOverlayStore} from "@/stores/useOverlayStore.js";

const overlay = useOverlayStore()
const overlayVisible = computed(() => overlay.isVisible)
</script>

<template>
  <div class="overlay z-50" v-if="overlayVisible"></div>
</template>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.8);
}
</style>
