<script setup lang="ts">
import { Event } from '~~/types/eventTypes';
import {DateTime} from 'luxon'
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";
import {AllRoles} from "~/enums/roles";
// props
const props = defineProps<{ event: Event }>();

const userStore = useUserStore();


const canEditEvent = computed(() => {
  return userStore.hasPermission(AllPermissions.canUpdateEvent) && (props.event.user_id === userStore.getUser?.id || userStore.hasRole(AllRoles.Admin))
});

// methods
const navigateToEvent = () => {
  navigateTo(`/event/edit/${props.event.id}`);
};
const navigateToEventJoin = () => {
  navigateTo(`/event/join/${props.event.id}`);
};


</script>

<template>
  <!-- card -->
  <div
    class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg hover:bg-gray-100 border-2 border-gray-200 transition duration-50 ease-in-out transform hover:-translate-y-1 hover:scale-101 border-2 border-gray-200 transition duration-50 ease-in-out transform hover:-translate-y-1 hover:scale-101"
  >
    <!-- litter image from provided litter image_path location -->
    <div class="flex justify-center min-h-60">
      <img
        class="w-fill h-fill object-cover"
        :src="event.image_path || 'https://via.placeholder.com/150'"
        alt="litter image"
      />

    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">Renginio pavadinimas: </h1>
      <h1 class="text-2xl text-gray-900">{{ event.title }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4 min-h-40">
      Aprašymas:
      <p class="text-gray-600">{{ event.description }}</p>
    </div>
    <!-- date -->
    <div class="mt-4">
      <p class="text-gray-600">Sukurtas: {{ DateTime.fromISO(event.created_at || "0").toFormat('yyyy-MM-dd HH:mm') }}</p>
    </div>
    <!-- size -->
    <div class="mt-4">
      <p class="text-gray-600">Prasideda: {{ event.starting_at }}</p>
    </div>
    
    
    <!-- button -->
    <div class="flex mt-4">
      <button
        v-if="canEditEvent"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToEvent"
      >
        Redaguoti
    </button>
    <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2"
        @click="navigateToEventJoin"
      >
        Plačiau!
    </button>
      <div
          v-if="event.has_ended"
          class="bg-red-500 rounded text-white font-bold py-2 px-4 rounded ml-2"
      >
        Pasibaigęs
      </div>
    <!-- if event.has_user_joined true, show green big text-->
    <p v-if="event.has_user_joined" class="text-2xl text-green-500">Jūs jau prisijungęs!</p>
    </div>
  </div>
</template>
