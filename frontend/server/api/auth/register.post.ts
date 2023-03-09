import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event, readBody} from 'h3'
import {RegisterCredentials} from "~/types/authTypes";
import {ServerSideResponse} from "~/types/generalTypes";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const data: RegisterCredentials = await readBody(event)

    const runtimeConfig = useRuntimeConfig()

    const userAgent = getHeader(event, 'user-agent')

    const body = {...data, user_agent: userAgent}

    try {
        const response = await useBackFetch(event, '/register', {method: 'POST', body})

        setCookie(event, runtimeConfig.public.authCookieName, `Bearer ${response.data}`, {httpOnly: true})

        return {status: response.status, data: response.data}
    } catch (e: any) {
        console.log(e)
        return {status: false, data: e.data}
    }
})