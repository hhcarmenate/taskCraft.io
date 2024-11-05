<script setup>

import BoardCard from "@/components/Workspace/workspace-boards/board-card/BoardCard.vue";
import WorkspaceCollaborators from "@/components/Workspace/workspace-members/collaborators/WorkspaceCollaborators.vue";
</script>

<template>
  <div class="w-[85%] flex flex-col mt-6">
    <h3 class="text-xl font-thin">
      Collaborators
    </h3>
    <WorkspaceCollaborators />
  </div>
</template>

<style scoped>

</style>
