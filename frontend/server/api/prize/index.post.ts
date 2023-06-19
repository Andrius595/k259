import { useBackFetch } from "~/composables/useBackFetch";
import { H3Event } from 'h3'
import { ServerSideResponse } from "~/types/generalTypes";
import formidable, { Fields, Files } from 'formidable'
import fs from "fs";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const form = formidable({ multiples: true })

    const data: any = await new Promise((resolve, reject) => {
        form.parse(event.node.req, (err, fields: Fields) => {
            if (err) {
                reject(err)
            }

            const duomenys = {
                name: fields.name[0],
                description: fields.description[0],
                price: fields.price[0],
                prize_codes: fields.prize_codes[0],
            }
            resolve({ fields: duomenys })
        })
    })


    const body = {
        ...data.fields,
    }
    console.log(body)
    try {
        const response = await useBackFetch(event, `api/prizes/`, {
            method: 'POST',
            body
        })

        return { status: response.status, data: response.data }
    } catch (e: any) {
        return { status: false, data: e.data }
    }
})
