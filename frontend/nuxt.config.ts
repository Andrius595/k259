// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    ssr: false,
    runtimeConfig: {
        public: {
            backendUrl: 'http://localhost:80',
            frontendUrl: 'http://localhost:3000',
            authCookieName: 'Authorization',
        },
    },
    imports: {
        dirs: ['./utils'],
    },
    modules: [
        'nuxt-windicss',
        '@element-plus/nuxt',
        '@pinia/nuxt',
    ]
})
