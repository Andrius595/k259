<script setup lang="ts">
//  table list of all litters from database

import { Litter } from '~~/types/litterTypes';
import LitterCard from '~/components/LitterCard.vue';

const LittersList = ref<Litter[]>([])
await loadLitters()

console.log('list', LittersList.value)
definePageMeta({middleware: ["auth"]});
async function loadLitters() {
  const response :any = await $fetch('/api/litter')
  if (response.status) {
    LittersList.value = response.data 
  }
}

</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Šiukšlių sąrašas</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Visų šiukšlių sąrašas
      </h2>
    </template>

    <div class="my-12">
      <!-- grid filled with <LitterCard> -->
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          
          <div class="p-6 bg-white border-b border-gray-200">
            <a href="/litter/create" class="pr-8">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Sukurti naują šiukšlę
        </button>
      </a>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <LitterCard v-for="litter in LittersList" :key="litter.id" :litter="litter" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
