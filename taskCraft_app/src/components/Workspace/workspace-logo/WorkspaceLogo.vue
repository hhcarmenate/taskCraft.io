<script setup>
import {useUserStore} from "@/stores/useUserStore.js";
import {computed, ref, watch} from "vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

const colors = [ 'primary', 'secondary', 'danger', 'black', 'warning', 'info', 'success', 'gray' ]
const tones = [ 50, 100, 200, 300, 400, 500, 600, 700, 800, 900]

const emit = defineEmits(['updated:image'])
defineProps({
  editable: {
    type: Boolean,
    default: true
  }
})

const fileInput = ref()
const localImage = ref()
const user = useUserStore()
const workspace = useWorkspaceStore()

const workspaceLogo = computed(() => {
  return localImage.value || workspace.currentWorkspace?.logo
})

const nameInitials = computed(() => {
  if (!user.name) return ''

  const nameParts = workspace.currentWorkspace?.name?.split(' ')

  return nameParts?.map(part => {
    return part[0].toUpperCase()
  }).join('')
})

const triggerFileUpload = () => {
  fileInput.value.click();
}

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      localImage.value = e.target.result
    }
    reader.readAsDataURL(file)
    emit('updated:logo', file)
  }
}

const getRandomElement = (array) => array[Math.floor(Math.random() * array.length)]

const generateRandomBgColor = () => {
  const color = getRandomElement(colors);
  const tone = getRandomElement(tones);
  return `bg-${color}-${tone}`;
};

const randomBgColor = ref(generateRandomBgColor());

watch(() => workspace.currentWorkspace, () => {
  randomBgColor.value = generateRandomBgColor();
});
</script>

<template>
  <div class="profile__image-container" @click="triggerFileUpload">
    <div class="rounded__image">
      <div
        v-if="workspaceLogo"
        class="image-container w-20 h-20 rounded-md overflow-hidden"
      >
        <img
          :src="workspaceLogo"
          alt="Profile Image"
          class="w-full h-full object-cover"
        >
      </div>
      <div
        v-if="!workspaceLogo"
        class="image-container w-20 h-20 rounded-md flex items-center justify-center text-white text-2xl"
        :class="randomBgColor"
      >
        <div class="initials">
          {{ nameInitials }}
        </div>
      </div>
    </div>
    <div
      class="flex mt-2 items-center justify-center text-white text-2xl"
    >
      <button
        v-if="false"
        @click="triggerFileUpload"
        type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      >
        Upload
      </button>
      <input
        type="file"
        ref="fileInput"
        @change="handleFileUpload"
        class="hidden"
      />
    </div>
  </div>
</template>

<style scoped>
.image-container {
  margin: 0 auto;
}

.initials {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: white;
}

.change-logo {
  position: absolute;

}
</style>
