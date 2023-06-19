<!-- Purpose: Display company information in a card
Props:
  company: Company object
Usage:
  <CompanyCard :company="company" />
-->

<template>
  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg hover:bg-gray-100 border-2 border-gray-200 transition duration-50 ease-in-out transform hover:-translate-y-1 hover:scale-101">
    <!-- company logo -->
    <div class="flex justify-center min-h-60">
      <img
        class="w-fill h-fill object-cover rounded-lg"
        :src="company.logo_src || 'https://via.placeholder.com/150'"
        alt="company logo"
      />
    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">{{ company.title }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4 min-h-40">
      <p class="text-gray-600">{{ company.description }}</p>
    </div>
    <!-- button -->
    <div class="mt-4">
      <button
          v-if="canEditCompany"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToCompany"
      >
        Redaguoti
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Company } from '~/types/companyTypes';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";

const userStore = useUserStore()
// props
const props = defineProps<{ company: Company }>()

const canEditCompany = computed(() => {
  return userStore.hasPermission(AllPermissions.canUpdateCompany)
})
// methods
const navigateToCompany = () => {
  navigateTo(`/company/edit/${props.company.id}`)
};
</script>
