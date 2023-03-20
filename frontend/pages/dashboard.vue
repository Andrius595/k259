<script setup lang="ts">
import {useUserStore} from "~/stores/userStore";
import LitterMap from '~/components/LitterMap.vue'
import { useGeolocation } from '@vueuse/core'
const { coords, locatedAt, error, resume, pause } = useGeolocation()
definePageMeta({middleware: ["auth"]});

const userStore = useUserStore();

const user = userStore.getUser;
</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Dashboard</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="my-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            Welcome,
            {{ user?.first_name }}, you're logged in!
          </div>
        </div>
      </div>
    </div>

    <!-- create litter button /litter/create.vue-->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight m-2">
            Šiukšlių žemėlapis 📍
          </h2>
          <LitterMap style="height: 500px"
              :myAccuracy="coords.accuracy"
              :myLatitude="coords.latitude"
              :myLongitude="coords.longitude"
              />
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
