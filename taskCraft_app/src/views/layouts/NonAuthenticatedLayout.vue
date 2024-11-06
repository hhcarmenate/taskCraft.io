<script setup>
import {RouterLink, RouterView, useRoute} from 'vue-router'
import HelloWorld from '@/components/HelloWorld.vue'
import {computed} from "vue";

const route = useRoute()

const invitationWorkspace = computed(() => {
  return route.name === 'invitation-link'
})

</script>

<template>
  <div class="shell h-screen">
    <div class="non-auth-container">
      <header>
        <div class="wrapper" v-if="!invitationWorkspace">
          <HelloWorld msg="Welcome to TaskCraft.io!" />

          <nav>
            <RouterLink :to="'/login'">Sign In</RouterLink>
            <RouterLink :to="'/register'">Sign Up</RouterLink>
          </nav>
        </div>
        <div class="wrapper" v-else>
          <div class="greetings">
            <h4>
              Empowering Your Workflow with Organized and Collaborative Task Management
            </h4>
            <img src="/images/collaboration.svg" alt="">
          </div>
        </div>
      </header>
      <RouterView />
    </div>
  </div>

</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  .shell {
    display: flex;
    align-items: center;
  }
  .non-auth-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 0 2rem;
  }

  header {
    display: flex;
    place-items: center;
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
