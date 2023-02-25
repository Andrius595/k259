import { H3Event, getCookie } from 'h3'
import { $fetch, FetchOptions } from 'ofetch'

export type BackResponseType = {
    status: boolean
    data: any
}

export const useBackFetch = async (event: H3Event, path: string, options: FetchOptions) => {
    const runtimeConfig = useRuntimeConfig()
    let authCookie = getCookie(event, runtimeConfig.public.authCookieName)

    let headers: any = {
        accept: "application/json",
        "content-type": "application/json",
        ...options.headers,
        authorization: authCookie
    };

    console.log('bf', path, headers)

    options.baseURL = runtimeConfig.public.backendUrl

    return await $fetch(path, {...options, headers}) as BackResponseType
};
