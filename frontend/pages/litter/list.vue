<script setup lang="ts">
//  table list of all litters from database

//import { useLitterStore } from "~/stores/litterStore";

//const litterStore = useLitterStore();
const data = ref({
  // liiter name
  litter_name: "",
  // liiter description
  litter_description: "",
  // liiter image
  litter_image: "",
  // liiter size
  litter_size: "",
  // liiter type
  litter_type: "",
  // liiter location
  litter_location: "",
  // liiter date
  litter_date: "",
  // liiter time
  litter_time: "",
});
</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Litter list</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List of all litters
      </h2>
    </template>

    <div class="my-12">
      <!-- grid filled with <LitterCard> -->
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
              <LitterCard>
                <template #image>
                  <img
                    src="https://picsum.photos/200/300"
                    alt="logo"
                    class="w-20 h-20"
                  />
                </template>

                <template #title>
                  <h1 class="text-2xl font-bold text-gray-900">Litter name</h1>
                </template>

                <template #description>
                  <p class="text-gray-600">Litter description</p>
                </template>
              </LitterCard>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
