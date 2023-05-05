<script setup lang="ts">
import {ServerSideResponse} from "~/types/generalTypes";

definePageMeta({middleware: ["guest"]});

const router = useRouter();

const data = ref({
  first_name: null,
  last_name: null,
  email: null,
  password: null,
  password_confirmation: null,
});
const errors = ref<Record<string, string[]>>({});

async function submitForm() {
  errors.value = {};

  const response: ServerSideResponse = await $fetch('/api/auth/register', {method: 'POST', body: data.value})

  if (response.status) {
    return navigateTo('/dashboard')
  }

  errors.value = response.data.errors
}
</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Registracija</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registracija
      </h2>
    </template>
    <div class="my-12">
      <!-- grid filled with <LitterCard> -->
      <div class="w-full mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

    <form @submit.prevent="submitForm">
      <!-- Name -->
      <div>
        <Label for="first_name">Vardas</Label>
        <Input
            id="first_name"
            type="text"
            class="block mt-1 w-full"
            v-model="data.first_name"
            :errors="errors.first_name"
            required
            autoFocus
        />
      </div>

      <div class="mt-4">
        <Label for="last_name">Pavardė</Label>
        <Input
            id="last_name"
            type="text"
            class="block mt-1 w-full"
            v-model="data.last_name"
            :errors="errors.last_name"
            required
        />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <Label for="email">El. paštas</Label>
        <Input
            id="email"
            type="email"
            class="block mt-1 w-full"
            v-model="data.email"
            :errors="errors.email"
            required
        />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <Label for="password">Slaptažodis</Label>
        <Input
            id="password"
            type="password"
            class="block mt-1 w-full"
            v-model="data.password"
            :errors="errors.password"
            required
            autoComplete="new-password"
        />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <Label for="password_confirmation">Patvirkinkite slaptažodį</Label>
        <Input
            id="password_confirmation"
            type="password"
            class="block mt-1 w-full"
            v-model="data.password_confirmation"
            :errors="errors.password_confirmation"
            required
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <NuxtLink
            href="/login"
            class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Esate prisiregistravę?
        </NuxtLink>

        <Button class="ml-3" type="submit">Registruotis</Button>
      </div>
    </form>
      </div>
    </div>
  </NuxtLayout>
</template>

<style scoped>

</style>