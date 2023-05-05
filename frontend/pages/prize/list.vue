<script setup lang="ts">
import { Prize } from '~~/types/prizeTypes';

import PrizeCard from '~/components/PrizeCard.vue';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";

const userStore = useUserStore()
const PrizeList = ref<Prize[]>([])
await loadPrizes()

const canCreateEvent = computed(() => {
  return userStore.hasPermission(AllPermissions.canCreateEvent)
})

async function loadPrizes() {
  const response :any = await $fetch('/api/event')
  if (response.status) {
    PrizeList.value = response.data 
  }
}

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
      <!-- grid filled with <LitterCard> -->
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <PrizeCard v-for="prize in PrizeList" :key="prize.id" :prize="prize" />
             </div>
          </div>
        </div> 
    </div>
  </NuxtLayout>
</template>
