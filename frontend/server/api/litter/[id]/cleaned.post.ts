import {useBackFetch} from "~/composables/useBackFetch";
import {H3Event} from 'h3'
import {ServerSideResponse} from "~/types/generalTypes";
import formidable, {Fields, Files} from "formidable";
import fs from "fs";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const litterId = event.context.params?.id
    const form = formidable({multiples: true})

    const data: any = await new Promise((resolve, reject) => {
        form.parse(event.node.req, (err, fields: Fields, files: Files) => {
            if (err) {
                reject(err)
            }

            const duomenys = {
                size: fields.size[0],
                description: fields.description[0],
                latitude: fields.latitude[0],
                longitude: fields.longitude[0],
                trash_types: fields['trash_types[]'],
                is_accessible_by_car: fields.is_accessible_by_car[0],
                is_located_in_hole: fields.is_located_in_hole[0],
                is_under_water: fields.is_under_water[0],
                is_on_the_waterside: fields.is_on_the_waterside[0],
                is_hard_to_reach: fields.is_hard_to_reach[0],
                is_cleaned: fields.is_cleaned[0],
            }

            let img = null
            const image = files.image
            if (Array.isArray(image)) {
                const f = fs.readFileSync(image[0].filepath)
                const blob = new Blob([f])
                img = new File([blob], image[0].originalFilename as string, {type: image[0].mimetype as string, lastModified: Date.now()})
            }

            resolve({fields: duomenys, files: img})
        })
    })

    const body = {
        ...data.fields,
        image: data.files
    }

    try {
        const response = await useBackFetch(event, `api/litters/${litterId}/cleaned`, {
            method: 'POST',
            sendsFiles: true,
            body
        })

        return {status: response.status, data: response.data}
    } catch (e: any) {
        return {status: false, data: e.data}
    }
})