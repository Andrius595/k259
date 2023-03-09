import {useBackFetch} from "~/composables/useBackFetch";
import { H3Event, readBody } from 'h3'
import {LoginCredentials} from "~/types/authTypes";
import {ServerSideResponse} from "~/types/generalTypes";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const data: LoginCredentials = await readBody(event)

    const runtimeConfig = useRuntimeConfig()

    const userAgent = getHeader(event, 'user-agent')

    const body = {...data, user_agent: userAgent}

    try {
        const response = await useBackFetch(event, '/login', {method: 'POST', body})

        if (response.status) {
            setCookie(event, runtimeConfig.public.authCookieName, `Bearer ${response.data}`, {httpOnly: true})
        }

        return { status: response.status, data: response.data }
    } catch(e: any) {
        return { status: false, data: e.data }
    }
})