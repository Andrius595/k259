<script setup lang="ts">
import { Litter } from "~~/types/litterTypes";
import LitterCard from "~/components/LitterCard.vue";
import { watch } from 'vue'
import {useUserStore} from "~/stores/userStore";

const LittersList = ref<Litter[]>([]);

const userStore = useUserStore();

const paginationData = ref({
  page: 1,
  perPage: 15,
  total: 0,
  sortBy: 'created_at',
  showCleaned: false,
  showMine: false,
})


await loadLitters();

watch(() => paginationData.value.showMine, () => {
  paginationData.value.page = 1
  loadLitters()
})

watch(() => paginationData.value.showCleaned, () => {
  paginationData.value.page = 1
  loadLitters()
})

async function loadLitters() {
  const response: any = await $fetch("/api/litter", {method: 'GET', query: paginationData.value});
  if (response.status) {
    const responseData = response.data
    LittersList.value = responseData.data;
    paginationData.value.page = responseData.current_page
    paginationData.value.perPage = responseData.per_page
    paginationData.value.total = responseData.total
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
            <div class="sm:flex justify-between">
              <a href="/litter/create" class="pr-8">
                <button v-if="userStore.isLoggedIn"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                  Sukurti naują šiukšlę
                </button>
              </a>
              <div class="flex gap-4 pt-2 sm:pt-0">
                <ul v-if="userStore.getUser" class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r bg-gray-200 rounded-t-md sm:rounded-t-none sm:rounded-l-md">
                    <div class="flex items-center">
                      <div class="w-full text-center py-3 mx-3">Pranešėjas</div>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showMine" :value="true" id="radio-mine" type="radio" value="" name="reporter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-mine" class="w-full py-3 mx-2 text-sm font-medium text-gray-900">Aš</label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showMine" :value="false" id="radio-not-mine" type="radio" value="" name="reporter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-not-mine" class="w-full py-3 mx-2 text-sm font-medium text-gray-900 whitespace-nowrap">Visi</label>
                    </div>
                  </li>
                </ul>
                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r bg-gray-200 rounded-t-md sm:rounded-t-none sm:rounded-l-md">
                    <div class="flex items-center">
                      <div class="w-full text-center py-3 mx-3">Būklė</div>
                    </div>                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showCleaned" :value="true" id="radio-cleaned" type="radio" name="is_cleaned" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-cleaned" class="w-full py-3 mx-2 text-sm font-medium text-gray-900">Surinktos</label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showCleaned" :value="false" id="radio-not-cleaned" type="radio" name="is_cleaned" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-not-cleaned" class="w-full py-3 mx-2 text-sm font-medium text-gray-900 whitespace-nowrap">Nesurinktos</label>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <LitterCard
                v-for="litter in LittersList"
                :key="litter.id"
                :litter="litter"
              />
            </div>
            <div v-if="LittersList.length === 0">
              <h3 class="text-center text-gray-700 text-2xl mt-4">Nėra šiukšlių atitinkančių pasirinktus parametrus</h3>
            </div>
            <div class="mt-2">
              <el-pagination
                  :hide-on-single-page="true"
                  class="justify-center"
                  v-model:current-page="paginationData.page"
                  :page-size="paginationData.perPage"
                  background
                  layout="prev, pager, next"
                  :total="paginationData.total"
                  @current-change="loadLitters"
              />
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
