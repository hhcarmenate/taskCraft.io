import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";

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
  }
];
