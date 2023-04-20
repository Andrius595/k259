import {UserData} from "~/types/userTypes";

export type Litter = {
    id: number
    user_id: number
    size: number
    latitude: string|number
    longitude: string|number
    image_path: string|null
    description: string|null
    is_accessible_by_car: 0|1
    is_located_in_hole: 0|1
    is_under_water: 0|1
    is_on_the_waterside: 0|1
    is_hard_to_reach: 0|1
    is_cleaned: 0|1
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    user?: UserData
}
