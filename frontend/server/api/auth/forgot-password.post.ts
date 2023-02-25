import {useBackFetch} from "~/composables/useBackFetch";
import { H3Event, readBody } from 'h3'
import {RegisterCredentials} from "~/types/authTypes";

export default defineEventHandler(async (event: H3Event) => {
    const body = await readBody(event)

    const response = await useBackFetch(event, '/forgot-password', {method: 'POST', body})

    return {
        response
    }
})