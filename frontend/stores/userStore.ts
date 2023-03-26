import { defineStore } from 'pinia'
import {UserData} from "~/types/userTypes";

// You can name the return value of `defineStore()` anything you want,
// but it's best to use the name of the store and surround it with `use`
// and `Store` (e.g. `useUserStore`, `useCartStore`, `useProductStore`)
// the first argument is a unique id of the store across your application
export const useUserStore = defineStore('user', {
    state: () => ({
       user: null as UserData | null
    }),
    getters: {
        getUser: (state) => state.user,
        getFullName: (state) => (
            state.user
                ? `${state.user.first_name} ${state.user.last_name}`
                : ''
        ),
        getPoints: (state) => (
            state.user
                ? `${state.user.points}`
                : '0'
        ),
    },
    actions: {
        setUser(userData: UserData) {
            this.user = userData
        }
    }
})