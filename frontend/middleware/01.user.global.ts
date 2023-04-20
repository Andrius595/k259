import {useUserStore} from "~/stores/userStore";

export default defineNuxtRouteMiddleware(async () => {
    const userStore = useUserStore();

    await userStore.fetchData()
});