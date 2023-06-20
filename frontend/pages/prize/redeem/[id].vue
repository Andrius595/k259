<script setup lang="ts">
import {Prize} from "~/types/prizeTypes";

definePageMeta({middleware: ["auth"]})
const route = useRoute();
const prizeId = ref(route.params.id ?? null)

const prize : any= ref<Prize | null>(null)
const successMessage = ref<string>('')
const errorMessage = ref<string>('')

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

    const response: any = await $fetch(`/api/prize/${prizeId.value}/redeem`, {
      method: "POST",
    });

    if (response.status) {
      successMessage.value = response.data.message

      return
    }

    errorMessage.value = response.data.message
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


          <div class="flex items-center justify-end mt-4">
            <NuxtLink
              href="/prizes/list"
              class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Atšaukti
            </NuxtLink>
            <Button class="ml-3">Atsiimti</Button>
          </div>
        </form>
        <el-alert
            v-if="successMessage"
            :title="successMessage"
            type="success"
            show-icon
            :closable="false"
            class="mt-5" />
        <el-alert
            v-if="errorMessage"
            :title="errorMessage"
            type="error"
            show-icon
            :closable="false"
            class="mt-5" />
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
