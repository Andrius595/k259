<script setup lang="ts">
import { Event } from '~~/types/eventTypes';

// props
const event = defineProps<{ event: Event }>();

// methods
const navigateToEvent = () => {
  navigateTo(`/event/edit/${event.event.id}`);
};
const navigateToEventJoin = () => {
  navigateTo(`/l`);
};


</script>

<template>
  <!-- card -->
  <div
    class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
  >
    <!-- litter image from provided litter image_path location -->
    <div class="flex justify-center">
      <img
        class="w-fill h-fill object-cover"
        :src="event.event.image_path || 'https://via.placeholder.com/150'"
        alt="litter image"
      />

    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">Renginio ID: {{ event.event.id }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4">
      Aprašymas:
      <p class="text-gray-600">{{ event.event.description }}</p>
    </div>
    <!-- date -->
    <div class="mt-4">
      <p class="text-gray-600">Sukurtas: {{ event.event.created_at }}</p>
    </div>
    <!-- size -->
    <div class="mt-4">
      <p class="text-gray-600">Prasideda: {{ event.event.starting_at }}</p>
    </div>
    <!-- button -->
    <div class="mt-4">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToEvent"
      >
        Redaguoti
    </button>
    <button
        class="bg-lime-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-5"
        @click="navigateToEventJoin"
      >
        Prisijungti!
    </button>
    </div>
  </div>
</template>
