<script setup>
import {computed, onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";
import {useUserStore} from "@/stores/useUserStore.js";
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";
import { JOB_POSITIONS } from "@/constants/index.js";
import MainUserProfileModal from "@/components/modals/UserProfile/MainUserProfileModal.vue";

const user = useUserStore()
const userProfile = useUserProfileStore()
const showUserProfileModal = ref(false)

onMounted(() => {
  initFlowbite()
})

const jobPosition = computed(() => {
  return JOB_POSITIONS.find((job) => job.value === userProfile.jobPosition)?.text
})

const openMainUserProfileModal = () => {
  showUserProfileModal.value = true
}

const handleUpdateShow = (value) => {
  showUserProfileModal.value = value
}
</script>

<template>
  <main>

    <section class="title font-thin text-2xl ml-4">
      <h1>User Profile</h1>
    </section>

    <section class="main mt-4">
      <div class="container">
        <div class="top-profile flex flex-row gap-2 justify-center">
          <div class="w-[40%] max-w-sm bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 pt-4">
              <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                <span class="sr-only">Open dropdown</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                  <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                </svg>
              </button>
              <!-- Dropdown menu -->
              <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2" aria-labelledby="dropdownButton">
                  <li>
                    <a
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-green-500"
                      @click="openMainUserProfileModal()"
                    >
                      Edit
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="flex flex-col items-center pb-10">
              <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Bonnie image"/>
              <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                {{ user.name }}
              </h5>
              <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ jobPosition ?? '' }}
              </span>
            </div>
            <MainUserProfileModal :show="showUserProfileModal" @update:show="handleUpdateShow" />
          </div>

          <div class="w-[100%] max-w-lg p-3 bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-row justify-between items-center">
              <div class="w-1/2">
                <h1 class="font-medium text-xl">General Info</h1>
              </div>

              <div class="flex justify-end w-1/2">
                <button
                  id="dropdownButton"
                  data-dropdown-toggle="dropdown-gi"
                  class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                  type="button"
                >
                  <span class="sr-only">Open dropdown</span>
                  <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                  </svg>
                </button>
                <!-- Dropdown menu -->
                <div
                  id="dropdown-gi"
                  class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                >
                  <ul class="py-2" aria-labelledby="dropdownButton">
                    <li>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Edit
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>


          </div>
        </div>



        <div class="w-full bg-white mt-5 border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
          <ul class="flex flex-wrap justify-center text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
            <li class="me-2">
              <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">About</button>
            </li>
            <li class="me-2">
              <button id="services-tab" data-tabs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Services</button>
            </li>
            <li class="me-2">
              <button id="statistics-tab" data-tabs-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Facts</button>
            </li>
          </ul>
          <div id="defaultTabContent" class="h-full min-h-[375px]">
            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
              <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Powering innovation & trust at 200,000+ companies worldwide</h2>
              <p class="mb-3 text-gray-500 dark:text-gray-400">Empower Developers, IT Ops, and business teams to collaborate at high velocity. Respond to changes and deliver great customer and employee service experiences fast.</p>
              <a href="#" class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">
                Learn more
                <svg class=" w-2.5 h-2.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
              </a>
            </div>
            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="services" role="tabpanel" aria-labelledby="services-tab">
              <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">We invest in the world’s potential</h2>
              <!-- List -->
              <ul role="list" class="space-y-4 text-gray-500 dark:text-gray-400">
                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                  </svg>
                  <span class="leading-tight">Dynamic reports and dashboards</span>
                </li>
                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                  </svg>
                  <span class="leading-tight">Templates for everyone</span>
                </li>
                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                  </svg>
                  <span class="leading-tight">Development workflow</span>
                </li>
                <li class="flex space-x-2 rtl:space-x-reverse items-center">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                  </svg>
                  <span class="leading-tight">Limitless business automation</span>
                </li>
              </ul>
            </div>
            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
              <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                <div class="flex flex-col">
                  <dt class="mb-2 text-3xl font-extrabold">73M+</dt>
                  <dd class="text-gray-500 dark:text-gray-400">Developers</dd>
                </div>
                <div class="flex flex-col">
                  <dt class="mb-2 text-3xl font-extrabold">100M+</dt>
                  <dd class="text-gray-500 dark:text-gray-400">Public repositories</dd>
                </div>
                <div class="flex flex-col">
                  <dt class="mb-2 text-3xl font-extrabold">1000s</dt>
                  <dd class="text-gray-500 dark:text-gray-400">Open source projects</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
