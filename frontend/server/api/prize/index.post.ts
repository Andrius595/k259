import { useBackFetch } from "~/composables/useBackFetch";
import { H3Event, readBody } from 'h3'
import { ServerSideResponse } from "~/types/generalTypes";
import formidable, { Fields, Files } from 'formidable'
import fs from "fs";


export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const body = await readBody(event);
    try {
        const response = await useBackFetch(event, `api/prizes`, {method: 'POST', body})

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})
