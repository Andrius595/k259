<script setup lang="ts">
import {Event} from '~~/types/eventTypes';

import EventCard from '~/components/EventCard.vue';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";
import {watch} from "vue";

const userStore = useUserStore()
const EventsList = ref<Event[]>([])

const paginationData = ref({
  page: 1,
  perPage: 15,
  total: 0,
  sortBy: 'created_at',
  showJoined: false,
  showUpcoming: false,
})

const canCreateEvent = computed(() => {
  return userStore.hasPermission(AllPermissions.canCreateEvent)
})

await loadEvents()

watch(() => paginationData.value.showJoined, () => {
  paginationData.value.page = 1
  loadEvents()
})

watch(() => paginationData.value.showUpcoming, () => {
  paginationData.value.page = 1
  loadEvents()
})

async function loadEvents() {
  const response: any = await $fetch('/api/event', { method: 'GET', query: paginationData.value})
  if (response.status) {
    const responseData = response.data
    EventsList.value = responseData.data;
    paginationData.value.page = responseData.current_page
    paginationData.value.perPage = responseData.per_page
    paginationData.value.total = responseData.total
  }
}

</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Renginių sąrašas</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Visų renginių sąrašas
      </h2>
    </template>

    <div class="my-12">
      <!-- grid filled with <LitterCard> -->
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="p-6 bg-white border-b border-gray-200">
            <div class="sm:flex justify-between">
              <div>
                <a v-if="canCreateEvent" href="/event/create" class="pr-8">
                  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Sukurti naują renginį
                  </button>
                </a>
              </div>
              <div class="flex gap-4 pt-2 sm:pt-0">
                <ul v-if="userStore.getUser" class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r bg-gray-200 rounded-t-md sm:rounded-t-none sm:rounded-l-md">
                    <div class="flex items-center">
                      <div class="w-full text-center py-3 mx-3">Dalyvavimas</div>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showJoined" :value="true" id="radio-mine" type="radio" value="" name="reporter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-mine" class="w-full py-3 mx-2 text-sm font-medium text-gray-900">Dalyvauju</label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showJoined" :value="false" id="radio-not-mine" type="radio" value="" name="reporter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-not-mine" class="w-full py-3 mx-2 text-sm font-medium text-gray-900 whitespace-nowrap">Nedalyvauju</label>
                    </div>
                  </li>
                </ul>
                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r bg-gray-200 rounded-t-md sm:rounded-t-none sm:rounded-l-md">
                    <div class="flex items-center">
                      <div class="w-full text-center py-3 mx-3">Data</div>
                    </div>                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showUpcoming" :value="true" id="radio-cleaned" type="radio" name="is_cleaned" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-cleaned" class="w-full py-3 mx-2 text-sm font-medium text-gray-900">Artėjantys</label>
                    </div>
                  </li>
                  <li class="w-full border-b border-gray-200 sm:border-b-0 dark:border-gray-600">
                    <div class="flex items-center pl-3">
                      <input v-model="paginationData.showUpcoming" :value="false" id="radio-not-cleaned" type="radio" name="is_cleaned" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0">
                      <label for="radio-not-cleaned" class="w-full py-3 mx-2 text-sm font-medium text-gray-900 whitespace-nowrap">Praėję</label>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <EventCard v-for="event in EventsList" :key="event.id" :event="event"/>
            </div>
            <div v-if="EventsList.length === 0">
              <h3 class="text-center text-gray-700 text-2xl mt-4">Nėra renginių atitinkančių pasirinktus parametrus</h3>
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
                  @current-change="loadEvents"
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
