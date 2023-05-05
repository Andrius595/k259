<script setup lang="ts">
import {Company} from '~~/types/companyTypes';
import CompanyCard from '~/components/CompanyCard.vue';
import {useUserStore} from "~/stores/userStore";
import {AllPermissions} from "~/enums/permissions";

const userStore = useUserStore()

const companiesList = ref<Company[]>([]);
await loadCompanies();

const canCreateCompany = computed(() => {
  return userStore.hasPermission(AllPermissions.canCreateCompany)
})

async function loadCompanies() {
  const response: any = await $fetch('/api/company');
  if (response.status) {
    companiesList.value = response.data;
  }
}

</script>

<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Remėjų sąrašas</Title>
    </Head>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Sąrašas visų remėjų
      </h2>
    </template>

    <div class="my-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <a v-if="canCreateCompany" href="/company/create" class="pr-8">
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Pridėti naują remėją 🆕
              </button>
            </a>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <!-- Check if companiesList is empty -->
              <template v-if="companiesList.length === 0">
                <p>Toks remėjas nerastas.</p>
              </template>

              <!-- If companiesList is not empty, display CompanyCard components -->
              <template v-else>
                <CompanyCard v-for="company in companiesList" :key="company.id" :company="company"/>
              </template>
            </div>

          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
