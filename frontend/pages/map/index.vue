<template>
  <NuxtLayout name="auth-layout">
    <template #header>Map</template>

    <LitterMap style="height: 600px" />
  </NuxtLayout>
</template>

<script setup lang="ts">
import LitterMap from '~/components/LitterMap.vue'
definePageMeta(['auth'])
</script>

<style scoped>
</style>