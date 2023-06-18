// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    ssr: false,
    runtimeConfig: {
        public: {
            backendUrl: process.env.BACKEND_URL || 'http://localhost',
            frontendUrl: process.env.FRONTEND_URL || 'http://localhost:3000',
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
        '@vueuse/nuxt',
    ]
})
