<script setup lang="ts">
definePageMeta({ middleware: ["guest"] });

const email = ref<string>('');
const resetEmailSent = ref(false);
const status = ref("");
const errors = ref<Record<string, string[]>>({});
const errorMessage = ref<string>('');

async function submitForm() {
  errors.value = {};
  status.value = "";
  errorMessage.value = "";

    const response :any = await $fetch('/api/auth/forgot-password', {method: 'POST', body: {email: email.value}})

    if (response.status) {
        resetEmailSent.value = true;
        status.value = response.data;

        return
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
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
      </NuxtLink>
    </template>

    <div class="mb-4 text-sm text-gray-600">
      Pamiršote slaptažodį? Jokių problemų. Tiesiog įveskite savo el. pašto adresą ir atsiųsime slaptažodžio
      nustatymo iš naujo nuorodą, kuri leis pasirinkti naują slaptažodį.
    </div>

    <!-- Session Status -->
    <AuthSessionStatus class="mb-4" :status="status" />

    <div v-if="errorMessage.length" class="mb-4 text-sm text-red-600">
      {{ errorMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <!-- Email Address -->
      <div>
        <Label for="email">El. paštas</Label>
        <Input
            id="email"
            type="email"
            class="block mt-1 w-full"
            v-model="email"
            :errors="errors.email"
            required
            autoFocus
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Button class="ml-3" :disabled="resetEmailSent">
           Siųsti el. paštą
        </Button>
      </div>
    </form>
  </AuthCard>
</template>