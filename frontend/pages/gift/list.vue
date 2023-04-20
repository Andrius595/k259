<script setup lang="ts">
//  table list of all litters from database

import { Gift } from '~~/types/giftTypes';
import GiftCard from '~/components/GiftCard.vue';

const GiftsList = ref<Gift[]>([])
await loadGifts()

async function loadGifts() {
  const response :any = await $fetch('/api/gift')
  if (response.status) {
    GiftsList.value = response.data 
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
          
          <div class="p-6 bg-white border-b border-gray-200">
            <a href="/litter/create" class="pr-8">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Sukurti naują prizą
        </button>
      </a>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <GiftCard v-for="gift in GiftsList" :key="gift.id" :gift="gift" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
