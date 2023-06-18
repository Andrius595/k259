<script setup lang="ts">

definePageMeta({middleware: ["auth"]})
const route = useRoute();
const prizeId = ref(route.params.id ?? null)

const prize : any= ref<Prize | null>(null)

await loadPrize()

async function loadPrize() {
  const response :any = await $fetch(`/api/prize/${prizeId.value}`)

  // TODO also check if user is admin or litter belongs to current user, otherwise redirect to list
  if (response.status) {
    prize.value = response.data
    return
  }
}

const data = ref({
    id: prizeId.value,
    name: prize.name,
    price: prize.price,
    description: prize.description,
    prizeCodes: prize.prizeCodes,
});

const errors = ref<Record<string, string[]>>({});
async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch(`/api/prize/${prizeId}/redeem`, {
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
      <Title>Atsiimti prizą</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Atsiimti prizą
        </h2>
      </div>
    </template>

    <div class="container mx-auto mt-10">
      <el-card>

        <!-- Prize name -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Prizas:
          </label>
          <p class="text-gray-700 text-base">
            {{ prize.name }}
          </p>
        </div>

        <!-- Prize price -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Kaina:
          </label>
          <p class="text-gray-700 text-base">
            {{ prize.price }} taškų
          </p>
        </div>

        <!-- Prize description -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Aprašymas:
          </label>
          <p class="text-gray-700 text-base">
            {{ prize.description }}
          </p>
        </div>

        <form @submit.prevent="submitForm">
            <!-- required toggle button "Noriu matyti kodą iškart -->
            <div class="mb-4">
              <el-switch
                v-model="data.isCodeVisible"
                active-text="Noriu gauti kodą į el. paštą"
                inactive-text="Noriu gauti kodą dabar"
                required
              />
            </div>

            <!-- required input "El. paštas" when toggle is set to on-->
            <div class="mb-4" v-if="data.isCodeVisible">
              <label class="block text-gray-700 text-sm font-bold mb-2">
                El. paštas:
              </label>
              <el-input
                v-model="data.email"
                required
              />
            </div>

            <!-- required ceckbox "Patvirtinu, kad suvesti duomenys yra teisingi" when toggle is on -->
            <div class="mb-4" v-if="data.isCodeVisible">
              <el-checkbox
                v-model="data.isDataCorrect"
                required
              >
                Patvirtinu, kad suvesti duomenys yra teisingi
              </el-checkbox>
            </div>

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
              href="/login"
              class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Atšaukti
            </NuxtLink>
            <Button class="ml-3">Atsiimti</Button>
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
