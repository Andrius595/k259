import {useBackFetch} from "~/composables/useBackFetch";
import { H3Event, readBody } from 'h3'
import {RegisterCredentials, ResetPasswordCredentials} from "~/types/authTypes";

export default defineEventHandler(async (event: H3Event) => {
    const body: ResetPasswordCredentials = await readBody(event)

    const response = await useBackFetch(event, '/reset-password', {method: 'POST', body})

    return {
        response
    }
})