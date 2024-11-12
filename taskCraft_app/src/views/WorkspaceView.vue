<script setup>
import WorkspaceIntro from "@/components/Workspace/workspace-intro/WorkspaceIntro.vue";
import SuggestedTemplates from "@/components/Workspace/suggested-templates/SuggestedTemplates.vue";
import WorkspaceBoard from "@/components/Workspace/workspace-boards/WorkspaceBoard.vue";


</script>

<template>
  <main>
    <section class="title font-thin text-2xl ml-4">
      <h1>Workspaces</h1>
    </section>

    <section class="main mt-4">
      <div class="container">
        <div class="w-full h-full flex flex-col min-h-[760px] bg-white border border-gray-200 rounded-sm shadow dark:bg-gray-800 dark:border-gray-700">
          <WorkspaceIntro />
          <div class="w-full flex flex-col justify-between items-center ">
            <div class="w-[85%] flex flex-row mt-4">
              <h1 class="text-2xl font-semibold">Boards</h1>
            </div>
            <SuggestedTemplates v-if="false" />

            <WorkspaceBoard />

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
