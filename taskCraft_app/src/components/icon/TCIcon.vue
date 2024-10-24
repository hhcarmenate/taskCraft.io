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
  }
})

const propClass = computed(() => props.class)
</script>

<template>
  <span>
    <Icon
      :class="propClass"
      :icon="icon"
    />
  </span>
</template>
