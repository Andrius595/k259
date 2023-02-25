export type LoginCredentials = {
    email: string
    password: string
    remember: boolean
}

export type RegisterCredentials = {
    email: string
    first_name: string
    last_name: string
    password: string
    password_confirmation: string
}

export type ResetPasswordCredentials = {
    email: string
    token: string
    password: string
    password_confirmation: string
}
