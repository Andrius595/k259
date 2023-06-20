<script setup lang="ts">
import {serialize} from 'object-to-formdata'
import {ServerSideResponse} from "~/types/generalTypes";

definePageMeta({ middleware: ["auth"] });


const prize: any= ref<Prize | null>(null)
const route = useRoute();
const prizeId = ref(route.params.id ?? null)

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()
const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");



await loadPrize()

async function loadPrize() {
  const response: ServerSideResponse = await $fetch(`/api/prize/${prizeId.value}`)
  if (response.status) {
    prize.value = response.data

    return
  }

  return await navigateTo('/prize/list')
}

async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  
  const response: any = await $fetch(`/api/prize/${prizeId.value}`, {
    method: 'PUT',
    body: prize.value
  })

  if (response.status) {
    successMessage.value = 'Prize updated successfully'

    return await navigateTo('/prize/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
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
      <el-card v-if="prize">
        <form @submit.prevent="submitForm">
          <!-- Name -->

          <div>
            <Label for="prize_name">Pavadinimas</Label>
            <Input
              v-model="prize.name"
              id="prize_name"
              type="text"
              class="block mt-1 w-full"
              :errors="errors.name"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="prize_description">Aprašymas</Label>
            <Textarea
                id="prize_description"
                class="block mt-1 w-full"
                v-model="prize.description"
                :errors="errors.description"
            />
          </div>

          <div class="mt-4">
            <Label for="prize_price">Kaina</Label>
            <Input
              id="prize_price"
              type="number"
              class="block mt-1 w-full"
              v-model="prize.price"
              :errors="errors.price"
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


