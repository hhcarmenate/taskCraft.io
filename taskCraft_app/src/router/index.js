import { createRouter, createWebHistory } from 'vue-router'
import NonAuthenticatedLayout from "@/views/layouts/NonAuthenticatedLayout.vue"
import {nonAuthenticatedRoutes} from "@/router/nonAuthRoutes.js"
import {authenticatedRoutes} from "@/router/authRoutes.js"
import AuthenticatedLayout from "@/views/layouts/AuthenticatedLayout.vue"

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
    {
      path: '',
      name: 'authenticated layout',
      component: AuthenticatedLayout,
      children: [
        ...authenticatedRoutes
      ]
    }
  ]
})

router.beforeEach((to, from, next ) => {
  const title = to.meta?.title ?? ''

  document.title = title ? `${title} | TaskCraft` : 'TaskCraft'

  next()
})

router.afterEach(() => {
  window.scrollTo(0,0)
})

export default router
