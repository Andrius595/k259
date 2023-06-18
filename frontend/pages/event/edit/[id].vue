<script setup lang="ts">

//'title','description','starting_at','latitude','longitude','image_path','has_ended',

const data = ref({
  // event title
  event_title: "",
  // event description
  event_description: "",
  // starting at date
  starting_date: "",
  // starting at time
  starting_time: "",
  // latitude
  latitude: "",
  // longitude
  longitude: "",
  // has ended
  has_ended: "",
  // image path
  image_path: ""
});

const errors = ref<Record<string, string[]>>({});
async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch("/api/event/update-event", {
      method: "POST",
      body: data.value,
    });
    // TODO show success message
  } catch (e) {
    // TODO show errors
  }
}
</script>

<template>
  <NuxtLayout name="auth-layout">


    <Head>
      <Title>Atnaujinti renginį</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Atnaujinti renginį
        </h2>
      </div>
    </template>

  
    <div class="container mx-auto mt-10">  
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Name -->

          <div>
            <Label for="event_title">Pavadinimas</Label>
            <Input
              id="event_title"
              type="text"
              class="block mt-1 w-full"
              v-model="data.event_title"
              :errors="errors.event_title"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="event_description">Aprašymas</Label>
            <Input
              id="event_description"
              type="text"
              class="block mt-1 w-full"
              v-model="data.event_description"
              :errors="errors.event_description"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="starting_date">Data</Label>
            <Input
              id="starting_date"
              type="date"
              class="block mt-1 w-full"
              v-model="data.starting_date"
              :errors="errors.starting_date"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="starting_time">Prasideda</Label>
            <Input
              id="starting_time"
              type="time"
              class="block mt-1 w-full"
              v-model="data.starting_time"
              :errors="errors.starting_time"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="longitude">Ilguma</Label>
            <Input
              id="longitude"
              type="text"
              class="block mt-1 w-full"
              v-model="data.longitude"
              :errors="errors.longitude"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="latitude">Platuma</Label>
            <Input
              id="latitude"
              type="text"
              class="block mt-1 w-full"
              v-model="data.latitude"
              :errors="errors.latitude"
              required
            />
          </div>

          
          <div class="mt-4">
            <Label for="image_path">Nuotrauka</Label>
            <Input
              id="image_path"
              type="file"
              class="block mt-1 w-full"
              v-model="data.image_path"
              :errors="errors.image_path"
              required
            />
          </div>

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
              href="/login"
              class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Atšaukti
            </NuxtLink>

            <Button class="ml-3">Išsaugoti</Button>
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
