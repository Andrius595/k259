<script setup lang="ts">
import { useGeolocation } from '@vueuse/core'
import {useUserStore} from "~/stores/userStore";
import LitterMap from '~/components/LitterMap.vue'
import { Prize } from "~~/types/prizeTypes";
import { Litter } from "~~/types/litterTypes";

import PrizeCard from "~/components/PrizeCard.vue";

const PrizeList = ref<Prize[]>([]);
const LitterList = ref<Litter[]>([]);
//wait for const { coords } = useGeolocation() to load, then continue
const { coords } = useGeolocation()

const userStore = useUserStore();

const user = userStore.getUser;
const PrizeCount = ref(0);
const LitterCount = ref(0);

await loadPrizes();
await loadLitters();

async function loadPrizes() {
  const response: any = await $fetch("/api/prize");
  if (response.status) {
    PrizeList.value = response.data;
    PrizeCount.value = PrizeList.value.length;
    //filter 3 prizes with lowest points
    PrizeList.value = PrizeList.value.sort((a, b) => a.price - b.price).slice(0, 3)
  }
}

async function loadLitters() {
  const response: any = await $fetch("/api/litter");
  if (response.status) {
    //where litter is not cleadned 
    LitterList.value = response.data.filter((litter: Litter) => litter.is_cleaned === 0);
    LitterCount.value = LitterList.value.length;
  }
}


</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Pagrindinis</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight cursor-default select-none
      ">
        Pagrindinis
      </h2>
    </template>


    <!-- create litter button /litter/create.vue-->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12 cursor-default">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight m-2 cursor-default select-none">
            Labas, {{user?.first_name}}! 
            <div class=" ml-10 inline-flex px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-green-100 text-green-800 
            ">
              Jūsų taškai: {{userStore.getPoints}}
            </div>
            <div class=" ml-10 inline-flex px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-blue-100 text-blue-800 
            ">
              Nesurinkta šiukšlių: {{LitterCount}}
            </div>
            <div class=" ml-10 inline-flex px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-yellow-100 text-yellow-800 
            ">
              Galimų prizų: {{PrizeCount}}
            </div>

          </h2>

          <!-- load map after coords is loaded -->
        </div>
      </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight m-2">
            Šiukšlių žemėlapis
          </h2>
          <!-- load map after coords is loaded -->
          <LitterMap style="height: 500px"
              :myAccuracy="coords.accuracy"
              :myLatitude="coords.latitude"
              :myLongitude="coords.longitude"
              />
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 cursor-default">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight m-2">
            Top savitės prizai:
          </h2>
          
          <!-- load three prizes in PrizeCard -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <PrizeCard
              v-for="prize in PrizeList"
              :key="prize.id"
              :prize="prize"
            />

          </div>
        </div>
      </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
