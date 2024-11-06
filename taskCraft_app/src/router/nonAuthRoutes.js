import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import JoinWorkspace from "@/components/Workspace/join-workspace/JoinWorkspace.vue";

export const nonAuthenticatedRoutes = [
  {
    path: '/',
    name: 'home',
    redirect: '/login',
    meta: {
      title: 'Home'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: {
      title: 'Sign In'
    }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    meta: {
      title: 'Sign Up'
    }
  },
  {
    path: '/invitation-link',
    name: 'invitation-link',
    component: JoinWorkspace,
    meta: {
      title: 'Join Workspace'
    }
  }
];
