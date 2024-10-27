<script setup>
import {computed} from 'vue';
import {useOverlay} from "@/stores/useOverlay.js";

const overlay = useOverlay()
const overlayVisible = computed(() => overlay.isVisible)
</script>

<template>
  <div class="overlay" v-if="overlayVisible"></div>
</template>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.8);
  z-index: 49;
}
</style>
