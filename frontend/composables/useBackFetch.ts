import {getCookie, H3Event} from 'h3'
import {$fetch, FetchOptions} from 'ofetch'
import {serialize} from 'object-to-formdata'

export type CustomFetchOptions = FetchOptions & { sendsFiles?: boolean }

export type BackResponseType = {
    status: boolean
    data: any
}

export const useBackFetch = async (event: H3Event, path: string, options: CustomFetchOptions) => {
    const runtimeConfig = useRuntimeConfig()
    let authCookie = getCookie(event, runtimeConfig.public.authCookieName)

    let headers: any = {
        accept: "application/json",
        ...options.headers,
        authorization: authCookie
    };

    if (options.sendsFiles) {
        // @ts-ignore
        options.body._method = options.method
        options.method = 'POST'
        options.body = serialize(options.body)
    }

    options.baseURL = runtimeConfig.public.backendUrl

    return await $fetch(path, {...options, headers}) as BackResponseType
};
