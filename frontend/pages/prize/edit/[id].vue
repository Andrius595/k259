<script setup lang="ts">

//'title','description','starting_at','latitude','longitude','image_path','has_ended',

const data = ref({
  // event title
  prize_name: "",
  // event description
  prize_description: "",
  // starting at date
  prize_price: ""
});

const errors = ref<Record<string, string[]>>({});
async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch("/api/prize/update-prize", {
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
      <Title>Atnaujinti prizą</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Atnaujinti prizą
        </h2>
      </div>
    </template>

  
    <div class="container mx-auto mt-10">  
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Name -->

          <div>
            <Label for="prize_name">Pavadinimas</Label>
            <Input
              id="prize_name"
              type="text"
              class="block mt-1 w-full"
              v-model="data.prize_name"
              :errors="errors.prize_name"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="prize_description">Aprašymas</Label>
            <Input
              id="prize_description"
              type="text"
              class="block mt-1 w-full"
              v-model="data.prize_description"
              :errors="errors.prize_description"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="prize_price">Kaina</Label>
            <Input
              id="prize_price"
              type="number"
              class="block mt-1 w-full"
              v-model="data.prize_price"
              :errors="errors.prize_price"
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
