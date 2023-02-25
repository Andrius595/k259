import {useUserStore} from "~/stores/userStore";

export default defineNuxtRouteMiddleware(async () => {
    const userStore = useUserStore();

    const user = await $fetch('/api/user', {method: 'GET'})

    if (!user) {
        userStore.$reset()

        return await navigateTo('/login')
    }

    userStore.setUser(user)
});