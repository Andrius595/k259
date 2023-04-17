import {BackResponseType, useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'

export default defineEventHandler(async (event: H3Event) => {
    try {
        const response: BackResponseType = await useBackFetch(event, '/api/roles', {method: 'GET'})

        return response.data
    } catch (e) {
        return []
    }

})