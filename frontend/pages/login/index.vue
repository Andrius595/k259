<script setup lang="ts">
definePageMeta({middleware: ["guest"]});

const router = useRouter();
const route = useRoute();

const data : any = ref({
  email: route.query.email ?? '',
  password: '',
  remember: false,
});
const status : any = ref(route.query.reset ?? "");
const errors = ref<Record<string, string[]>>({});
const errorMessage = ref<string>("");

async function submitForm() {
  errors.value = {};
  errorMessage.value = "";
  status.value = "";

  const response :any = await $fetch('/api/auth/login', {method: 'post', body: data.value})

  if (response.status) {
    return await navigateTo('/dashboard')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}
</script>

<template>
  <AuthCard>
    <template #logo>
      <NuxtLink to="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
      </NuxtLink>
    </template>

    <!-- Session Status -->
    <AuthSessionStatus class="mb-4" :status="status"/>

    <div v-if="errorMessage.length" class="mb-4 text-sm text-red-600">
      {{ errorMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <!-- Email Address -->
      <div>
        <Label for="email">el. paštas</Label>
        <Input
            id="email"
            type="email"
            class="block mt-1 w-full"
            v-model="data.email"
            :errors="errors.email?.[0]"
            required
            autoFocus
        />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <Label for="password">slaptažodis</Label>
        <Input
            id="password"
            type="password"
            class="block mt-1 w-full"
            v-model="data.password"
            :errors="errors.password"
            required
            autoComplete="current-password"
        />
      </div>

      <div class="flex items-center justify-end mt-3">
        <NuxtLink
            href="/forgot-password"
            class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Pamiršote slaptažodį?
        </NuxtLink>

        <Button class="ml-3">Prisijungti</Button>
        <Button class="ml-3" type="button" @click="navigateTo('/register')" >Register</Button>
      </div>
    </form>
  </AuthCard>
</template>