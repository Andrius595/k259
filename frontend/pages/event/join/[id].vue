<template>
  <NuxtLayout name="auth-layout">


    <Head>
      <Title>Peržiūrėti renginį</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Peržiūrėti renginį
        </h2>
      </div>
    </template>

    <div class="container mx-auto mt-10">  
      <el-card>
        
        <!-- event name -->
        <div class="mt-4">
          <h1 class="text-2xl font-bold text-gray-900">Renginio pavadinimas: {{ event.title }}</h1>
        </div>

        <!-- event image -->
        <div class="mt-4">
          <img :src="event.image_path" alt="event image" class="w-full">
        </div>

        <!-- event description -->
        <div class="mt-4">
          <h1 class="text-xl font-bold text-gray-900">Aprašymas:</h1>
          <p class="text-gray-900">{{ event.description }}</p>
        </div>

        <!-- event date -->
        <div class="mt-4">
          <h1 class="text-xl font-bold text-gray-900">Data:</h1>
          <p class="text-gray-900">{{ event.starting_at }}</p>
        </div>

        <!-- event joined_users_count -->
        <div class="mt-4">
          <h1 class="text-xl font-bold text-gray-900">Dalyvių skaičius:</h1>
          <p class="text-gray-900">{{ event.joined_users_count }}</p>
          
        </div>

        <!-- join event button -->
        <form class="mt-5" @submit.prevent="submitForm">
          <div class="mt-4">
            <Button class="ml-3">Prisijungti</Button>
        </div>
        </form>
        





      </el-card>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import { serialize } from "object-to-formdata";
definePageMeta({middleware: ["auth"]})
const route = useRoute();
const eventId = ref(route.params.id ?? null)

const event : any= ref<Event | null>(null)

const errors = ref<Record<string, string>>({})
const errorMessage = ref<string>('')
const successMessage = ref<string>('')

await loadEvent()

async function loadEvent() {
  const response :any = await $fetch(`/api/event/${eventId.value}`)

  // TODO also check if user is admin or litter belongs to current user, otherwise redirect to list
  if (response.status) {
    event.value = response.data
    return
  }
}

const joinEvent = () => {
  navigateTo(`/event/list/`);
};
const data = {
    ...event.value,
    has_user_joined:  event.value.has_user_joined ? false : true,
    event_id: eventId.value
  }

const body = serialize(data)

async function submitForm() {
  errors.value = {}

  try {
    //api/events/{event}/join
    const response = await $fetch(`/api/event/${eventId.value}/join`, {
      method: "POST",
      body,
    })
    // TODO show success message
    successMessage.value = response.message
    //joinEvent()
  } catch (e) {
    // TODO show errors
    errorMessage.value = e.message
  }
}

</script>