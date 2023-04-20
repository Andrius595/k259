// Purpose: Display gift information in a card
//
// Props:
//   gift: Gift object
//
// Usage:
//   <GiftCard :gift="gift" />

//Property 'gift' does not exist on type

<script setup lang="ts">
import { Gift } from '~~/types/giftTypes';

// props
const gift = defineProps<{ gift: Gift }>();

// methods
const navigateToGift = () => {
  navigateTo(`/gift/edit/${gift.gift.id}`);
};
const navigateToGiftCollect = () => {
  navigateTo(`/gift/collect/${gift.gift.id}`);
};


</script>

<template>
  <!-- card -->
  <div
    class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
  >
    <!-- gift image from provided gift image_path location -->
    <div class="flex justify-center">
      <img
        class="w-fill h-fill object-cover"
        :src="gift.gift.image_src || 'https://via.placeholder.com/150'"
        alt="gift image"
      />

    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">Prizo ID: {{ gift.gift.id }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4">
      Aprašymas:
      <p class="text-gray-600">{{ gift.gift.description }}</p>
    </div>
    <!-- date -->
    <!-- button -->
    <div class="mt-4">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToGift"
      >
        Redaguoti
    </button>
    <button
        class="bg-lime-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-5"
        @click="navigateToLitterCollect"
      >
        Surinkti!
    </button>
    </div>
  </div>
</template>
