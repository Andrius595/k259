
enum CompanyManagementPermissions {
    canCreateCompany = 'can create company',
    canUpdateCompany = 'can update company',
    canDeleteCompany = 'can delete company',
}

enum UserManagementPermissions {
    canCreateUser = 'can create user',
    canUpdateUser = 'can update user',
    canDeleteUser = 'can delete user',
}

enum EventManagementPermissions {
    canCreateEvent = 'can create event',
    canUpdateEvent = 'can update event',
    canDeleteEvent = 'can delete event',
    canMarkEventAsEnded = 'can mark event as ended',
}

enum LitterManagementPermissions {
    canUpdateLitter = 'can update litter',
    canDeleteLitter = 'can delete litter',
    canMarkLitterAsCleaned = 'can mark litter as cleaned',
}

enum PrizeManagementPermissions {
    canCreatePrize = 'can create prize',
    canUpdatePrize = 'can update prize',
    canDeletePrize = 'can delete prize',
}

export const AllPermissions = { ...CompanyManagementPermissions, ...UserManagementPermissions, ...LitterManagementPermissions, ...EventManagementPermissions, ...PrizeManagementPermissions }
export type AllPermissions = typeof AllPermissions
