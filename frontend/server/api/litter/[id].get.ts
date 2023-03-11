import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const litterId = event.context.params?.id

    try {
        const response = await useBackFetch(event, `api/litters/${litterId}`, {method: 'GET'})

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})