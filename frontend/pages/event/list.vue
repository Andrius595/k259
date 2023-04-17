<script setup lang="ts">
import { Event } from '~~/types/eventTypes';

import EventCard from '~/components/EventCard.vue';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";

const userStore = useUserStore()
const EventsList = ref<Event[]>([])
await loadLitters()

const canCreateEvent = computed(() => {
  return userStore.hasPermission(AllPermissions.canCreateEvent)
})

async function loadLitters() {
  const response :any = await $fetch('/api/event')
  if (response.status) {
    EventsList.value = response.data 
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
            <a v-if="canCreateEvent" href="/event/create" class="pr-8">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Sukurti naują renginį
        </button>
      </a>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!--once load Litters is finished display litter card-->
              <EventCard v-for="event in EventsList" :key="event.id" :event="event" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
