<script setup lang="ts">
import {useUserStore} from "~/stores/userStore";

definePageMeta({middleware: ["auth"]});

const router = useRouter();
const userStore = useUserStore()

const data = ref({
  first_name: userStore.getUser?.first_name ?? '',
  last_name: userStore.getUser?.last_name ?? '',
  email: userStore.getUser?.email ?? '',
});
const errors = ref<Record<string, string[]>>({});
const errorMessage = ref<string>('');

async function submitForm() {
  errors.value = {};

    const response :any = await $fetch('/api/user/update-profile', {method: 'POST', body: data.value})

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
  <NuxtLayout name="auth-layout">
    <div class="container mx-auto mt-10">
      <el-card>
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

          <div class="flex items-center justify-end mt-4">
            <a
                href="http://ec2-3-65-60-170.eu-central-1.compute.amazonaws.com:8025/"
                target="_blank"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Email simulation
            </a>

            <Button class="ml-3">Išsaugoti</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>