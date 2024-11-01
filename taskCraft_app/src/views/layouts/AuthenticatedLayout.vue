<script setup>
import Header from '@/components/Header/Header.vue'
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import ModalOverlay from "@/components/modals/ModalOverlay.vue";
import {onMounted} from "vue";
import { initFlowbite } from 'flowbite'
import {useUserStore} from "@/stores/useUserStore.js";
import LoadingPage from "@/components/LoadingPage/LoadingPage.vue";

const user = useUserStore()

onMounted(async () => {
  initFlowbite()

  await user.loadAppData()
});

</script>

<template>
  <LoadingPage v-if="user.loadingData"/>
  <div
    v-else
    class="antialiased bg-gray-50 dark:bg-gray-900"
  >
    <Header />

    <Sidebar />

    <main class="p-4 md:ml-64 h-screen pt-20 ">
      <router-view />
    </main>
  </div>
  <ModalOverlay />
</template>

<style scoped>

</style>
