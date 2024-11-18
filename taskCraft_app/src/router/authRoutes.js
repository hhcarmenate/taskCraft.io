import DashboardView from "@/views/DashboardView.vue"
import {useUserStore} from "@/stores/useUserStore.js"
import ProfileView from "@/views/ProfileView.vue"
import WorkspaceView from "@/views/WorkspaceView.vue"
import WorkspaceMembersView from "@/views/WorkspaceMembersView.vue"
import BoardView from "@/views/BoardView.vue"

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
    path: '/workspace/:name/members',
    name: 'workspace members',
    component: WorkspaceMembersView,
    meta: {
      title: 'Workspace Members'
    }
  },
  {
    path: '/board/:id',
    name: 'board',
    component: BoardView,
    meta: {
      title: 'Board'
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
]
