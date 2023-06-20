import {defineStore} from 'pinia'
import {UserData} from "~/types/userTypes";

// You can name the return value of `defineStore()` anything you want,
// but it's best to use the name of the store and surround it with `use`
// and `Store` (e.g. `useUserStore`, `useCartStore`, `useProductStore`)
// the first argument is a unique id of the store across your application
export const useUserStore = defineStore('user', {
    state: () => ({
        user: null as UserData | null,
        roles: useLocalStorage('pinia/auth/roles', [] as string[]),
        permissions: useLocalStorage('pinia/auth/permissions', [] as string[]),
    }),
    getters: {
        isLoggedIn: (state) => !!state.user,
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
        getRoles: (state) => state.roles,
        getPermissions: (state) => state.permissions,
    },
    actions: {
        async fetchData() {
            const user = await $fetch('/api/user', { method: 'GET' });

            if (!user) {
                this.clearState()
                return
            }

            if (this.roles.length === 0) {
                const roles = await $fetch('/api/user/roles', { method: 'GET' });
                this.setRoles(roles)
            }

            if (this.permissions.length === 0) {
                const permissions = await $fetch('/api/user/permissions', { method: 'GET' });
                this.setPermissions(permissions)
            }

            this.setUser(user)
        },
        setUser(userData: UserData) {
            this.user = userData
        },
        setRoles(roles: string[]) {
            localStorage.setItem('pinia/auth/roles', JSON.stringify(roles))
            this.roles = roles
        },
        setPermissions(permissions: string[]) {
            localStorage.setItem('pinia/auth/permissions', JSON.stringify(permissions))
            this.permissions = permissions
        },
        hasPermission(permission: string) {
            return this.permissions.includes(permission)
        },
        hasRole(role: string) {
            return this.roles.includes(role)
        },
        clearState() {
            localStorage.setItem('pinia/auth/roles', JSON.stringify([]))
            localStorage.setItem('pinia/auth/permissions', JSON.stringify([]))
            this.$reset()
        }
    },
    hydrate(state) {
        state.roles = useLocalStorage('pinia/auth/roles', [] as string[]) as unknown as string[]
        state.permissions = useLocalStorage('pinia/auth/permissions', [] as string[]) as unknown as string[]
    }
})