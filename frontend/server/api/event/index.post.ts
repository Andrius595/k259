import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";
import formidable, {Fields, Files} from 'formidable'
import fs from "fs";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const form = formidable({multiples: true})

    const data: any = await new Promise((resolve, reject) => {
        form.parse(event.node.req, (err, fields: Fields, files: Files) => {
            if (err) {
                reject(err)
            }

            const duomenys = {
                title: fields.event_title[0],
                description: fields.event_description[0],
                starting_at: fields.starting_date[0],
                latitude: fields.latitude[0],
                longitude: fields.longitude[0],

                  // event title
                /*event_title: "",
                // event description
                event_description: "",
                // starting at date
                starting_date: "",
                // starting at time
                starting_time: "",
                // latitude
                latitude: coords.value?.latitude === Infinity ? 54.687157 : coords.value.latitude,
                // longitude
                longitude: coords.value?.longitude === Infinity ? 25.279652 : coords.value.longitude,
                // has ended
                has_ended: "",
                // image path
                image_path: ""*/

                //'title' => 'required|integer',
                //'description' => 'nullable|string',
                //'dateTime' => 'required|DateTime',
                //'latitude' => 'required|numeric|min:-90|max:90',
                //'longitude' => 'required|numeric|min:-180|max:180',
                //'image_path' => 'nullable|image'
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
        const response = await useBackFetch(event, `api/events/`, {
            method: 'POST',
            sendsFiles: true,
            body
        })

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})
