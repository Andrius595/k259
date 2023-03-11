import {UserData} from "~/types/userTypes";

export type Litter = {
    id: number
    user_id: number
    size: number
    latitude: string|number
    longitude: string|number
    image_path: string|null
    description: string|null
    is_accessible_by_car: boolean
    is_located_in_hole: boolean
    is_under_water: boolean
    is_on_the_waterside: boolean
    is_hard_to_reach: boolean
    is_cleaned: boolean
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    user?: UserData
}
