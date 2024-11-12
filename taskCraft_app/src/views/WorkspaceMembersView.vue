<script setup>
import {onMounted} from "vue";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";
import {useRoute} from "vue-router";
import WorkspaceIntro from "@/components/Workspace/workspace-intro/WorkspaceIntro.vue";
import SuggestedTemplates from "@/components/Workspace/suggested-templates/SuggestedTemplates.vue";
import WorkspaceMembers from "@/components/Workspace/workspace-members/WorkspaceMembers.vue";

const workspace = useWorkspaceStore()
const route = useRoute()

onMounted(() => {
  if (!workspace.currentWorkspace && route.params.name) {
    workspace.initCurrentWorkspace(route.params.name)
  }
})

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
              <h1 class="text-2xl font-semibold">Members</h1>
            </div>
            <SuggestedTemplates v-if="false" />

            <WorkspaceMembers />
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
