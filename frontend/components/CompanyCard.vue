<!-- Purpose: Display company information in a card
Props:
  company: Company object
Usage:
  <CompanyCard :company="company" />
-->

<template>
  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <!-- company logo -->
    <div class="flex justify-center">
      <img
        class="w-fill h-fill object-cover"
        :src="company.logo_Src || 'https://via.placeholder.com/150'"
        alt="company logo"
      />
    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">{{ company.title }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4">
      <p class="text-gray-600">{{ company.description }}</p>
    </div>
    <!-- button -->
    <div class="mt-4">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToCompany"
      >
        Edit
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Company } from '~/types/companyTypes';

// props
const company = defineProps<{ company: Company }>();

// methods
const navigateToCompany = () => {
  navigateTo(`/company/edit/${company.company.id}`);
};
</script>
