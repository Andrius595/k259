export type Prize = {
    id: number
    name: string
    price: number
    description: string
    prizeCodes: {
        id: number
        prize_id: number
        code: string
        is_redeemed: boolean 
    }[]
}