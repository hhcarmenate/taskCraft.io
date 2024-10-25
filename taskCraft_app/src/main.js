import './assets/main.css'
import './assets/tailwind.css'
import 'flowbite';
import 'flowbite/dist/flowbite.css';
import clickOutside from './directives/click-outside';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'


const app = createApp(App)

app.use(createPinia())
app.use(router)
app.directive('click-outside', clickOutside);
app.mount('#app')
