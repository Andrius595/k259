<script setup lang="ts">
import {Prize} from '~~/types/prizeTypes';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";
import {AllRoles} from "~/enums/roles";
// props
const props = defineProps<{ prize: Prize }>();

const userStore = useUserStore();


const canEditPrize = computed(() => {
  return userStore.hasPermission(AllPermissions.canUpdatePrize) && ( userStore.hasRole(AllRoles.Admin))
});

//can claim prize if pize.price is less than user.points
const canClaimPrize = computed(() => {
  return ( userStore.hasRole(AllRoles.Admin)) || (userStore.user?.points >= props.prize.price)
});


// methods
const navigateToEdit = () => {
  navigateTo(`/prize/${props.prize.id}/edit/`);
};

const navigateToClaim = () => {
  navigateTo(`/prize/redeem/${props.prize.id}/`);
};

</script>

<template>
  <!-- card -->
  <div
      class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg hover:bg-gray-100 border-2 border-gray-200 transition duration-50 ease-in-out transform hover:-translate-y-1 hover:scale-101 border-2 border-gray-200 transition duration-50 ease-in-out transform hover:-translate-y-1 hover:scale-101"
  
  >
  <!-- title -->
  <div class="mt-4">
    <h1 class="text-2xl font-bold text-gray-900">Prizas: </h1>
    <h1 class="text-2xl text-gray-900">{{ prize.name }}</h1>
  </div>
  <!-- description -->
  <div class="mt-4 min-h-40">
    Aprašymas:
    <p class="text-gray-600">{{ prize.description }}</p>
  </div>
  <!-- size -->
  <div class="mt-4">
    <p class="text-gray-600">Kaina: {{ prize.price }} taškų</p>
  </div>
  
  <!-- button -->
  <div class="mt-4">
    <button
        v-if="canClaimPrize"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToClaim"
    >
      Atsiimti
    </button>
    <button
        v-if="canEditPrize"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        @click="navigateToEdit"
    >
      Redaguoti
    </button>
  </div>
  </div>
  
</template>
