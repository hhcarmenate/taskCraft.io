<script setup>
import {onMounted} from "vue";
import {initFlowbite} from "flowbite";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {useRoute} from "vue-router";
import SelectInput from "@/components/fields/SelectInput.vue";
import WorkspaceIntro from "@/components/Workspace/WorkspaceIntro.vue";

const workspace = useWorkspaceStore()
const route = useRoute()

onMounted(() => {
  initFlowbite()

  console.log(route.params)
  if (!workspace.currentWorkspace && route.params.name) {
    workspace.initCurrentWorkspace(route.params.name)
  }
})

</script>

<template>
  <main>
    <section class="title font-thin text-2xl ml-4">
      <h1>User Profile</h1>
    </section>

    <section class="main mt-4">
      <div class="container">
        <div class="w-full h-full flex flex-col min-h-[760px] bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
          <WorkspaceIntro />
          <div class="w-full flex flex-col justify-between items-center ">
            <div class="w-[85%] flex flex-row mt-4">
              <h1 class="text-2xl font-semibold">Boards</h1>
            </div>
            <div class="w-[85%] flex flex-col mt-2">
              <h1 class="text-lg font-extraligh">Suggested Templates</h1>
              <div class="w-full flex flex-row gap-2 items-center">
                <div>
                  <p>Get going faster with a template </p>
                </div>

                <div class="w-1/4">
                  <SelectInput
                    name="type"
                    :items="[{value: 'test1', text: 'Test 1'}, {value: 'test2', text: 'Test 2'}]"
                    show-error
                  />
                </div>
              </div>
              <div class="mt-6">
                <a href="#" class="underline text-green-700">Browse Full Template Gallery</a>
              </div>
            </div>

            <div class="w-[85%] flex flex-col mt-6">
              <div class="grid grid-cols-4 gap-4">
                <!-- Replace the divs below with your actual content/components -->
                <div class="bg-secondary-700 rounded rounded-4 p-6 hand">
                  Create New Board
                </div>
                <div class="bg-blue-200 rounded rounded-4 p-6">
                  Item 2
                </div>
                <div class="bg-blue-300 rounded rounded-4 p-6">Item 3</div>
                <div class="bg-blue-400 rounded rounded-4 p-6">Item 4</div>
              </div>
              <div class="board-image flex justify-center items-center mt-3">
                <div class="image-container w-[60%]">
                  <img src="/images/boards.svg" alt="">
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>
  </main>
</template>
<style scoped>
.hand {
  cursor: pointer;
}
</style>
