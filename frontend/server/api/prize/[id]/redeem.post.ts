import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const prizeId = event.context.params?.id

    try {
        const response = await useBackFetch(event, `api/prizes/${prizeId}/redeem`, {method: 'POST'})

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})