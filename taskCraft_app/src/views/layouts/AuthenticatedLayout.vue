<script setup>
import Header from '@/components/Header/Header.vue'
import Sidebar from "@/components/Sidebar/Sidebar.vue";
</script>

<template>
  <div class="antialiased bg-gray-50 dark:bg-gray-900">
    <Header />

    <Sidebar />

    <main class="p-4 md:ml-64 h-screen pt-20 ">
      <router-view />
    </main>
  </div>
</template>

<style scoped>

</style>
