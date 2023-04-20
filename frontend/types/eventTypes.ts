import {UserData} from "~/types/userTypes";

export type Event = {
    id: number
    user_id: number
    title: string
    description: string|null
    starting_at: string|null
    latitude: string|number
    longitude: string|number
    image_path: string|null
    has_ended: 1|0
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    has_user_joined: 1|0
    user?: UserData
}