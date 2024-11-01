import DashboardView from "@/views/DashboardView.vue";
import {useUserStore} from "@/stores/useUserStore.js";
import ProfileView from "@/views/ProfileView.vue";
import WorkspaceView from "@/views/WorkspaceView.vue";

export const authenticatedRoutes = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView,
    meta: {
      title: 'Dashboard'
    }
  },
  {
    path: '/profile',
    name: 'profile',
    component: ProfileView,
    meta: {
      title: 'Profile'
    }
  },
  {
    path: '/workspace/:name',
    name: 'workspace',
    component: WorkspaceView,
    meta: {
      title: 'Workspace'
    }
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
