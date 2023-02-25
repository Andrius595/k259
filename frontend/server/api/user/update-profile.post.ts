import {useBackFetch} from "~/composables/useBackFetch";
import { H3Event } from 'h3'

export default defineEventHandler(async (event: H3Event) => {
    const body = await readBody(event)

    const response = await useBackFetch(event, 'update-profile', {method: 'POST', body})

    return {
        response
    }
})