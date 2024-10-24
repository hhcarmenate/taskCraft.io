import { createRouter, createWebHistory } from 'vue-router'
import NonAuthenticatedLayout from "@/views/layouts/NonAuthenticatedLayout.vue";
import {nonAuthenticatedRoutes} from "@/router/nonAuthRoutes.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '',
      name: 'non authenticated layout',
      component: NonAuthenticatedLayout,
      children: [
        ...nonAuthenticatedRoutes
      ]
    },
  ]
})

export default router
