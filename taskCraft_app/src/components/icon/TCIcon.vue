<script setup>
import {Icon} from "@iconify/vue";
import {computed} from "vue";

const props = defineProps({
  icon: {
    type: String,
    default: 'heroicons-outline:home'
  },
  class: {
    type: String,
    default: null
  },
  hand: {
    type: Boolean,
    default: false
  }
})

const propClass = computed(() => props.class)
</script>

<template>
  <span :class="{'hand': hand}">
    <Icon
      :class="propClass"
      :icon="icon"
    />
  </span>
</template>
<style scoped>
.hand {
  cursor: pointer;
}
</style>
