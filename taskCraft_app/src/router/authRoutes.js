import DashboardView from "@/views/DashboardView.vue";
import {useUserStore} from "@/stores/useUserStore.js";

export const authenticatedRoutes = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView
  },
  {
    path: '/logout',
    name: 'logout',
    beforeEnter: async (to, from, next) => {
      const user = useUserStore()
      await user.logOut()
      await next({ name: 'login' })
    }
  }
];
