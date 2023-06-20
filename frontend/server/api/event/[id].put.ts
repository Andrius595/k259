import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";
import formidable, {Fields, Files} from 'formidable'
import fs from "fs";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const eventId = event.context.params?.id
    const form = formidable({multiples: true})

    const data: any = await new Promise((resolve, reject) => {
        form.parse(event.node.req, (err, fields: Fields, files: Files) => {
            if (err) {
                reject(err)
            }

            const duomenys = {
                title: fields.title[0],
                description: fields.description[0],
                starting_at: fields.starting_date[0],
                latitude: fields.latitude[0],
                longitude: fields.longitude[0],

            }

            let img = null
            if (files.image) {
                const f = fs.readFileSync(files.image[0].filepath)
                const blob = new Blob([f])
                img = new File([blob], files.image[0].originalFilename, {
                    type: files.image[0].mimetype,
                    lastModified: Date.now()
                })
            }

            resolve({fields: duomenys, files: img})
        })
    })


    const body = {
        ...data.fields,
        image: data.files
    }
    console.log(body)
    try {
        const response = await useBackFetch(event, `api/events/${eventId}`, {
            method: 'PUT',
            sendsFiles: true,
            body
        })

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})
