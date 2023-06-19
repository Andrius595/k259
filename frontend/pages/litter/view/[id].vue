<script setup lang="ts">
import {TrashType} from "~/types/trashTypeTypes";
import {Litter} from "~/types/litterTypes";
import {useGeolocation} from "@vueuse/core";
import {AllPermissions} from "~/enums/permissions";
import {useUserStore} from "~/stores/userStore";
import {AllRoles} from "~/enums/roles";

const userStore = useUserStore();

const { coords, error} = useGeolocation();
const route = useRoute();

const litterId = ref(route.params.id ?? null);

const litter: any = ref<Litter | null>(null);
const trashTypes = ref<TrashType[]>([]);

const selectedTrashTypes = ref<number[]>([]);

const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");

const litterSizeOptions = [
  { value: 1, label: "Mažas" },
  { value: 2, label: "Vidutinis" },
  { value: 3, label: "Didelis" },
];

await loadLitter();
await loadTrashTypes();

async function loadLitter() {
  const response: any = await $fetch(`/api/litter/${litterId.value}`);

  // TODO also check if user is admin or litter belongs to current user, otherwise redirect to list
  if (response.status) {
    litter.value = response.data;
    selectedTrashTypes.value = response.data.trash_types.map(
      (trashType: TrashType) => trashType.id
    );

    return;
  }

  return await navigateTo("/litter/list");
}


async function loadTrashTypes() {
  const response: any = await $fetch("/api/trash-types");
  if (response.status) {
    trashTypes.value = response.data;

    return;
  }
 
  // navigate to list, because unable to load trash types
  return await navigateTo("/litter/list");
}


const canEditLitter = computed(() => {
  return (
    userStore.hasPermission(AllPermissions.canUpdateLitter) &&
    (litter.value.user_id === userStore.getUser?.id ||
      userStore.hasRole(AllRoles.Admin))
  );
});

const canCleanLitter = computed(() => {
  return (
    litter.value.is_cleaned === 0 &&
    userStore.hasPermission(AllPermissions.canMarkLitterAsCleaned)
  );
});

const navigateToLitter = () => {
  navigateTo(`/litter/edit/${litter.value.id}`);
};
const navigateToLitterCollect = () => {
  navigateTo(`/litter/collect/${litter.value.id}`);
};

const navigateToList = () => {
  navigateTo("/litter/list");
};


</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Peržiūrėti šiukšlę</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Peržiūrėti šiukšlę
        </h2>
        <div v-if="litter?.is_cleaned">
          <div class="bg-green-600 py-2 px-4 rounded">
            <span class="text-white">Išvalyta</span>
          </div>
        </div>
      </div>
    </template>

    <div class="container mx-auto mt-10">
      <div v-if="errorMessage.length" class="mb-4 text-sm text-red-600">
        {{ errorMessage }}
      </div>
      <div v-if="successMessage.length" class="mb-4 text-sm text-green-600">
        {{ successMessage }}
      </div>

      <el-card v-if="litter">
        <div v-if="litter.user">
          <span>Pranešė: </span>
          <span v-if="litter.user">{{
            `${litter.user.first_name} ${litter.user.last_name}`
          }}</span>
          <span v-else>Anonimas</span>
        </div>

        <div class="mt-4">
          <span v-if="litter.image_path">
            <img :src="litter.image_path" class="w-64 h-64 object-cover" />
          </span>
          <span v-else>Nuotrauka nepridėta</span>
        </div>

        <LitterMapForForm
              id="litterMapForForm"
              style="height: 500px;"
              :latitude="litter.latitude"
              :longitude="litter.longitude"
              :myAccuracy="coords.accuracy"
              :myLatitude="coords.latitude"
              :myLongitude="coords.longitude"
              @update:latLng="updateCoordinates"
              class="mt-4"
            />

        <div class="mt-4">
          <Label for="litter_size">Šiukšlių dydis: </Label>
          <span>{{ litterSizeOptions[litter.size - 1].label }}</span>
        </div>

        <div class="mt-4">
          <Label for="litter_description">Aprašymas: </Label>
          <span>{{ litter.description }}</span>
        </div>

        <div class="mt-4">
          <Label for="litter_image_path">Koordinatės: </Label>
          <span>{{ litter.latitude }}, {{ litter.longitude }}</span>
        </div>
        
        <!-- div with 5 columns -->

        <div class="row mt-4 mb-4 pb-4 w-full flex flex-wrap justify-between items-center gap-4 text-center
        ">
          <div class="col">
            <Label for="litter_image_path">Prieinama automobiliu: </Label>
            <span>{{ litter.is_accessible_by_car ? "✅" : "❌" }}</span>
          </div>
          <div class="col">
            <Label for="litter_image_path">Yra duobėje: </Label>
            <span>{{ litter.is_located_in_hole ? "✅" : "❌" }}</span>
          </div>
          <div class="col">
            <Label for="litter_image_path">Yra po vandeniu: </Label>
            <span>{{ litter.is_under_water ? "✅" : "❌" }}</span>
          </div>
          <div class="col">
            <Label for="litter_image_path">Yra prie vandens: </Label>
            <span>{{ litter.is_on_the_waterside ? "✅" : "❌" }}</span>
          </div>
          <div class="col">
            <Label for="litter_image_path">Yra sunkiai pasiekiamas: </Label>
            <span>{{ litter.is_hard_to_reach ? "✅" : "❌" }}</span>
          </div>
        </div>
        

        <button
          class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2 bg-gray-500"
          @click="navigateToList"
        >
            Atgal
        </button>

        <button
          v-if="canEditLitter"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
          @click="navigateToLitter"
        >
          Redaguoti
        </button>
        <button
          v-if="canCleanLitter"
          class="bg-lime-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
          @click="navigateToLitterCollect"
        >
          Surinkti!
        </button>
      </el-card>
      <!--back button -->
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200"></div>
      </div>
    </div>
  </NuxtLayout>
</template>
