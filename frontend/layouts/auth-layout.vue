<script setup lang="ts">
import {useUserStore} from "~/stores/userStore";

const route = useRoute();
const verified = computed(() => !!route.query.verified);

const userStore = useUserStore();

if (!userStore.getUser) {
  await userStore.fetchData()
}
</script>

<template>
  <div class="min-h-screen bg-blue-200">
    <Navigation />

    <!-- Page Heading  -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <main>
      <!-- Email Verification Success Message -->
      <!-- Make sure to set (HOME = '/dashboard') in Laravel's RouteServiceProvdier.php -->
      <div v-if="verified" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="my-12 p-6 bg-gray-900 text-white font-semibold shadow-sm sm:rounded-lg"
        >
          Jūsų el. paštas patvirtintas, ačiū!
        </div>
      </div>

      <!-- Page Content -->
      <slot />
    </main>
  </div>
</template>