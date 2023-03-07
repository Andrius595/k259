<script setup lang="ts">
import { useUserStore } from "~/stores/userStore";

definePageMeta({ middleware: ["auth"] });

const userStore = useUserStore();

const user = userStore.getUser;
</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Laravel - Dashboard</Title>
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

            <a href="/litter/create" class="pr-8">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Litter
              </button>
            </a>
            
            <a href="/litter/list" class="pr-8">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Litter list
              </button>
            </a>

            <a href="/event/create" class="pr-8">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create event
              </button>
            </a>
          </div>
          
        </div>
      </div>

  </NuxtLayout>
</template>
