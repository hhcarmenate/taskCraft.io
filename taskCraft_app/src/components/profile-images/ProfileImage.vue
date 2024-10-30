<script setup>
import {useUserStore} from "@/stores/useUserStore.js";
import {computed, ref} from "vue";
import {useUserProfileStore} from "@/stores/useUserProfileStore.js";

const emit = defineEmits(['updated:image'])
const props = defineProps({
  editable: {
    type: Boolean,
    default: true
  }
})

const fileInput = ref()
const localImage = ref()
const user = useUserStore()
const userProfile = useUserProfileStore()

const profileImage = computed(() => {
  return userProfile.profilePicture || localImage.value
})

const nameInitials = computed(() => {
  if (!user.name) return ''

  const nameParts = user.name.split(' ')

  return nameParts.map(part => {
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
    emit('updated:image', file)
  }
}


</script>

<template>
  <div class="profile__image-container">
    <div class="rounded__image">
      <div
        v-if="profileImage"
        class="image-container w-32 h-32 rounded-full overflow-hidden"
      >
        <img
          :src="profileImage"
          alt="Profile Image"
          class="w-full h-full object-cover"
        >
      </div>
      <div
        v-if="!profileImage"
        class="image-container w-32 h-32 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl"
      >
        <div class="initials">
          {{ nameInitials }}
        </div>
      </div>
    </div>
    <div
      v-if="editable"
      class="flex mt-2 items-center justify-center text-white text-2xl"
    >
      <button
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
</style>
