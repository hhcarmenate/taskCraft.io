import './assets/main.css'
import './assets/tailwind.css'
import 'flowbite/dist/flowbite.css'
import clickOutside from './directives/click-outside'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import 'flowbite'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import './plugins/echo.js'


const app = createApp(App)
const pinia = createPinia()

app.use(pinia.use(piniaPluginPersistedstate))
app.use(router)
app.directive('click-outside', clickOutside)
app.mount('#app')
