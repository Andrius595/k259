import {useUserStore} from "~/stores/userStore";
import {useCookie} from "#imports";

export default defineNuxtRouteMiddleware(async () => {
    const userStore = useUserStore()


    const user = await $fetch('/api/user', {method: 'GET'})

    console.log('authGuest', user)

    if (user) {
        userStore.setUser(user)

        return await navigateTo('/dashboard')
    }


    userStore.$reset()
});