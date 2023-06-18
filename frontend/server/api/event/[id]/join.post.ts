import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";
import formidable, {Fields, Files} from "formidable";
import fs from "fs";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const litterId = event.context.params?.id
    const form = formidable({multiples: true})

    const data: any = await new Promise((resolve, reject) => {
        form.parse(event.node.req, (err, fields: Fields) => {
            if (err) {
                reject(err)
            }

            const duomenys = {
                //BBZ KA CIA DAR RASYT
                has_user_joined: fields.has_user_joined[0],
                event_id: fields.event_id[0],
                
            }
            resolve({fields: duomenys})
        })
    })

    const body = {
        ...data.fields,
    }

    try {
        const response = await useBackFetch(event, `api/events/${eventId}/join`, {
            method: 'POST',
            body
        })

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})