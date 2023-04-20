// Purpose: Display litter information in a card
//
// Props:
//   litter: Litter object
//
// Usage:
//
<LitterCard :litter="litter"/>

//Property 'litter' does not exist on type

<script setup lang="ts">
import {Litter} from '~~/types/litterTypes';
import {DateTime} from 'luxon'
import {AllPermissions} from "~/enums/permissions";
import {useUserStore} from "~/stores/userStore";
import {AllRoles} from "~/enums/roles";

const userStore = useUserStore();

// props
const props = defineProps<{ litter: Litter }>();

// methods
const navigateToLitter = () => {
  navigateTo(`/litter/edit/${props.litter.id}`);
};
const navigateToLitterCollect = () => {
  navigateTo(`/litter/collect/${props.litter.id}`);
};

const canEditLitter = computed(() => {
  return userStore.hasPermission(AllPermissions.canUpdateLitter) && (props.litter.user_id === userStore.getUser?.id || userStore.hasRole(AllRoles.Admin))
});

const canCleanLitter = computed(() => {
  return props.litter.is_cleaned === 0 && userStore.hasPermission(AllPermissions.canMarkLitterAsCleaned)
})

function formatSize(size: number) {
  switch (size) {
    case 1:
      return 'Mažas';
    case 2:
      return 'Vidutinis';
    case 3:
      return 'Didelis';
  }
}
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
          :src="litter.image_src || 'https://via.placeholder.com/150'"
          alt="litter image"
      />

    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">Šiukšlės ID: {{ litter.id }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4">
      Aprašymas:
      <p class="text-gray-600">{{ litter.description }}</p>
    </div>
    <!-- date -->
    <div class="mt-4">
      <p class="text-gray-600">Laikas: {{ DateTime.fromISO(litter.created_at).toFormat('yyyy-MM-dd HH:mm') }}</p>
    </div>
    <!-- size -->
    <div class="mt-4">
      <p class="text-gray-600">Dydis: {{ formatSize(litter.size) }}</p>
    </div>
    <!-- button -->
    <div class="mt-4">
      <button
          v-if="canEditLitter"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          @click="navigateToLitter"
      >
        Redaguoti
      </button>
      <button v-if="canCleanLitter"
              class="bg-lime-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-5"
              @click="navigateToLitterCollect"
      >
        Surinkti!
      </button>
    </div>
  </div>
</template>
