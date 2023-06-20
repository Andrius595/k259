<script setup lang="ts">
import { Prize } from "~~/types/prizeTypes";

import PrizeCard from "~/components/PrizeCard.vue";
import { useUserStore } from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";

const userStore = useUserStore();
const PrizeList = ref<Prize[]>([]);
await loadPrizes();

//ran

async function loadPrizes() {
  const response: any = await $fetch("/api/prize");
  if (response.status) {
    PrizeList.value = response.data;
  }
}
const canCreatePrize = computed(() => {
  return userStore.hasPermission(AllPermissions.canCreatePrize)
})
</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Prizų sąrašas</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Visų prizų sąrašas
      </h2>
    </template>

    <div class="my-12">
      <!--  -->
      <!-- grid filled with <LitterCard> -->
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div>
                <a v-if="userStore.isLoggedIn" href="/prize/create" class="pr-8">
                  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Sukurti naują prizą
                  </button>
                </a>
              </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <PrizeCard
                v-for="prize in PrizeList"
                :key="prize.id"
                :prize="prize"
              />
            </div>
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
