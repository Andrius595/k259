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
  <AuthCard>
    <template #logo>
      <NuxtLink href="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
      </NuxtLink>
    </template>

    <form @submit.prevent="submitForm">
      <!-- Name -->
      <div>
        <Label for="first_name">First Name</Label>
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
        <Label for="last_name">Last Name</Label>
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
        <Label for="email">Email</Label>
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
        <Label for="password">Password</Label>
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
        <Label for="password_confirmation">Confirm Password</Label>
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
          Already registered?
        </NuxtLink>

        <Button class="ml-3" type="submit">Register</Button>
      </div>
    </form>
  </AuthCard>
</template>

<style scoped>

</style>