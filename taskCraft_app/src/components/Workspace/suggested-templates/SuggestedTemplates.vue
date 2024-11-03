<script setup>

import SelectInput from "@/components/fields/SelectInput.vue";
</script>

<template>
  <div class="w-[85%] flex flex-col mt-2">
    <h1 class="text-lg font-extraligh">Suggested Templates</h1>
    <div class="w-full flex flex-row gap-2 items-center">
      <div>
        <p>Get going faster with a template </p>
      </div>

      <div class="w-1/4">
        <SelectInput
          name="type"
          :items="[{value: 'test1', text: 'Test 1'}, {value: 'test2', text: 'Test 2'}]"
          show-error
        />
      </div>
    </div>
    <div class="mt-6">
      <a href="#" class="underline text-green-700">Browse Full Template Gallery</a>
    </div>
  </div>
</template>

<style scoped>

</style>
