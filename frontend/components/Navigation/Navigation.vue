<script setup lang="ts">
import { useUserStore } from "~/stores/userStore";

const userStore = useUserStore();
const open = ref(false);

async function handleLogout() {
  await $fetch("/api/auth/logout", { method: "post" });
  userStore.clearState();

  return await navigateTo("/login");
}
</script>

<template>
  <nav class="bg-white border-b border-gray-200 cursor-default">
    <!-- Primary Navigation Menu  -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo  -->
          <div class="flex-shrink-0 flex items-center">
            <NuxtLink href="/dashboard">
              <ApplicationLogo
                class="block h-17 w-auto fill-current text-gray-600"
              />
            </NuxtLink>
          </div>

          <!-- Navigation Links  -->
          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavigationLink href="/dashboard"> Pagrindinis 🏠</NavigationLink>
          </div>

          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavigationLink href="/litter/list">Šiukšlės 🚮</NavigationLink>
          </div>

          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavigationLink href="/event/list">Renginiai 🥳</NavigationLink>
          </div>

          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavigationLink href="/company/list">Remėjai 🤝</NavigationLink>
          </div>

          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavigationLink href="/prize/list">Prizai 🎁</NavigationLink>
          </div>
        </div>
        <!-- points bubble -->
        <div v-if="userStore.isLoggedIn"
          class=" flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium leading-5 text-black  focus:outline-none transition duration-150 ease-in-out
        "
        >
          <span
            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-green-100 text-green-800
        "
          >
            Taškai: {{userStore.getPoints}}
          </span>
        </div>

        <!-- Settings Dropdown  -->
        <div
          v-if="userStore.isLoggedIn"
          class="hidden sm:flex sm:items-center sm:ml-6"
        >
          <client-only>
            <el-dropdown>
              <button
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out"
              >
                <div>{{ userStore.getFullName }}</div>

                <div class="ml-1">
                  <svg
                    class="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fillRule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clipRule="evenodd"
                    />
                  </svg>
                </div>
              </button>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item @click="navigateTo('/edit-profile')"
                    >Redaguoti profilį</el-dropdown-item
                  >
                </el-dropdown-menu>
                <el-dropdown-menu>
                  <el-dropdown-item @click="handleLogout"
                    >Atsijungti</el-dropdown-item
                  >
                </el-dropdown-menu>
              </template>
              <!-- Authentication  -->
            </el-dropdown>
          </client-only>
        </div>
        <div v-else class="flex justify-between items-center">
          <NavigationLink to="/login">Prisijungimas</NavigationLink>
          <NavigationLink to="/register">Registracija</NavigationLink>
        </div>

        <!-- Hamburger  -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
            @click="open = !open"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:text-gray-500 transition duration-150 ease-in-out"
          >
            <svg
              class="h-6 w-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                v-if="open"
                class="inline-flex"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M6 18L18 6M6 6l12 12"
              />
              <path
                v-else
                class="inline-flex"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu  -->
    <div v-show="open" class="block sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
          <NavigationResponsiveLink href="/dashboard"> Pagrindinis 🏠</NavigationResponsiveLink>
          <NavigationResponsiveLink href="/litter/list">Šiukšlės 🚮</NavigationResponsiveLink>
          <NavigationResponsiveLink href="/event/list">Renginiai 🥳</NavigationResponsiveLink>
          <NavigationResponsiveLink href="/company/list">Remėjai 🤝</NavigationResponsiveLink>
          <NavigationResponsiveLink href="/prize/list">Prizai 🎁</NavigationResponsiveLink>
      </div>
      <!-- Responsive Settings Options  -->
      <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="flex items-center px-4">
          <div class="ml-3">
            <div class="font-medium text-base text-gray-800">
              {{ userStore.getFullName }}
            </div>
            <div v-if="userStore.getUser" class="font-medium text-sm text-gray-500">
              {{ userStore.getUser.email }}
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <NavigationResponsiveButton @click="navigateTo('/edit-profile')">
            Redaguoti profilį
          </NavigationResponsiveButton>
          <!-- Authentication  -->
          <NavigationResponsiveButton @click="handleLogout">
            Atsijungti
          </NavigationResponsiveButton>
        </div>
      </div>
    </div>
  </nav>
</template>
