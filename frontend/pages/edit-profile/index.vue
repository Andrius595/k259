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

async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch('/api/user/update-profile', {method: 'POST', body: data.value})
    // TODO show success message
  } catch (e) {
    // TODO show errors
  }
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

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
                href="/login"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Already registered?
            </NuxtLink>

            <Button class="ml-3">Register</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>