<script setup lang="ts">
import {useUserStore} from "~/stores/userStore";

definePageMeta({middleware: ['auth']})

const userStore = useUserStore()

const user = userStore.getUser
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
            {{ user.first_name }}, you're logged in!
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>