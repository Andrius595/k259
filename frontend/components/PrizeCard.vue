<script setup lang="ts">
import { Prize } from '~~/types/prizeTypes';
import {DateTime} from 'luxon'
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";
import {AllRoles} from "~/enums/roles";
// props
const props = defineProps<{ prize: Prize }>();

const userStore = useUserStore();


const canEditPrize = computed(() => {
  return userStore.hasPermission(AllPermissions.canUpdatePrize) && (props.prize.user_id === userStore.getUser?.id || userStore.hasRole(AllRoles.Admin))
});


// methods
const navigateToPrize = () => {
  navigateTo(`/prize/edit/${props.prize.id}`);
};


</script>

<template>
  <!-- card -->
  <div
    class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
  >
    </div>
    <!-- title -->
    <div class="mt-4">
      <h1 class="text-2xl font-bold text-gray-900">Prizas: </h1>
      <h1 class="text-2xl text-gray-900">{{ gift.name }}</h1>
    </div>
    <!-- description -->
    <div class="mt-4">
      Aprašymas:
      <p class="text-gray-600">{{ prize.description }}</p>
    </div>
    <!-- size -->
    <div class="mt-4">
      <p class="text-gray-600">Kaina: {{ prize.price }}</p>
    </div>
    <!-- button -->
    <div class="mt-4">
      <button
        v-if="canEditPrize"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToEvent"
      >
        Redaguoti
    </button>
    </div>
  </div>
</template>
