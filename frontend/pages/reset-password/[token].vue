<script setup lang="ts">
definePageMeta({ middleware: ["guest"] });

const router = useRouter();
const route = useRoute();

if (!route.query.email) {
  router.push("/");
}

const data = ref({
  email: route.query.email as string,
  password: null,
  password_confirmation: null,
});
const errors = ref<Record<string, string[]>>({});
const errorMessage = ref<string>('');
const token = computed(() => route.params.token);

async function submitForm() {
  errors.value = {};
  errorMessage.value = '';

    const response :any = await $fetch('/api/auth/reset-password', {method: 'POST', body: {token: token.value, ...data.value}})

  if (response.status) {
    return navigateTo(`/login?reset=${response.data}&email=${data.value.email}`)
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
      <NuxtLink href="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
      </NuxtLink>
    </template>

    <div v-if="errorMessage.length" class="mb-4 text-sm text-red-600">
      {{ errorMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <!-- Email Address -->
      <div class="mt-4">
        <Label for="email">El. paštas</Label>
        <Input
            id="email"
            type="email"
            class="block mt-1 w-full opacity-80"
            v-model="data.email"
            :errors="errors.email"
            disabled
            required
        />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <Label for="password">Naujas slaptažodis</Label>
        <Input
            id="password"
            type="password"
            class="block mt-1 w-full"
            v-model="data.password"
            :errors="errors.password"
            required
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
        <Button>Atnaujinti slaptažodį</Button>
      </div>
    </form>
  </AuthCard>
</template>