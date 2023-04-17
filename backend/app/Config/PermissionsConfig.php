<?php

namespace App\Config;

class PermissionsConfig
{
    public const ADMIN = 'Admin';
    public const COMPANY_ADMIN = 'Company Admin';
    public const USER = 'User';

    public const ADMIN_PERMISSIONS = [
        ...self::COMPANY_MANAGEMENT_PERMISSIONS,
        ...self::USER_MANAGEMENT_PERMISSIONS,
        ...self::EVENT_MANAGEMENT_PERMISSIONS,
        ...self::LITTER_MANAGEMENT_PERMISSIONS,
        ...self::PRIZE_MANAGEMENT_PERMISSIONS,
    ];

    public const COMPANY_ADMIN_PERMISSIONS = [
        ...self::USER_MANAGEMENT_PERMISSIONS,
        ...self::EVENT_MANAGEMENT_PERMISSIONS,
        ...self::LITTER_MANAGEMENT_PERMISSIONS,
        ...self::PRIZE_MANAGEMENT_PERMISSIONS,
    ];

    public const USER_PERMISSIONS = [
        ...self::EVENT_MANAGEMENT_PERMISSIONS,
        ...self::LITTER_MANAGEMENT_PERMISSIONS,
    ];

    public const COMPANY_MANAGEMENT_PERMISSIONS = [
        self::CAN_CREATE_COMPANY,
        self::CAN_UPDATE_COMPANY,
        self::CAN_DELETE_COMPANY,
    ];

    public const USER_MANAGEMENT_PERMISSIONS = [
        self::CAN_CREATE_USER,
        self::CAN_UPDATE_USER,
        self::CAN_DELETE_USER,
    ];

    public const EVENT_MANAGEMENT_PERMISSIONS = [
        self::CAN_CREATE_EVENT,
        self::CAN_UPDATE_EVENT,
        self::CAN_DELETE_EVENT,
        self::CAN_MARK_EVENT_AS_ENDED,
    ];

    public const LITTER_MANAGEMENT_PERMISSIONS = [
        self::CAN_UPDATE_LITTER,
        self::CAN_DELETE_LITTER,
        self::CAN_MARK_LITTER_AS_CLEANED,
    ];

    public const PRIZE_MANAGEMENT_PERMISSIONS = [
        self::CAN_CREATE_PRIZE,
        self::CAN_UPDATE_PRIZE,
        self::CAN_DELETE_PRIZE,
    ];

    public const CAN_CREATE_COMPANY = 'can create company';
    public const CAN_UPDATE_COMPANY = 'can update company';
    public const CAN_DELETE_COMPANY = 'can delete company';

    public const CAN_CREATE_USER = 'can create user';
    public const CAN_UPDATE_USER = 'can update user';
    public const CAN_DELETE_USER = 'can delete user';

    public const CAN_CREATE_EVENT = 'can create event';
    public const CAN_UPDATE_EVENT = 'can update event';
    public const CAN_DELETE_EVENT = 'can delete event';
    public const CAN_MARK_EVENT_AS_ENDED = 'can mark event as ended';

    public const CAN_UPDATE_LITTER = 'can update litter';
    public const CAN_DELETE_LITTER = 'can delete litter';
    public const CAN_MARK_LITTER_AS_CLEANED = 'can mark litter as cleaned';

    public const CAN_CREATE_PRIZE = 'can create prize';
    public const CAN_UPDATE_PRIZE = 'can update prize';
    public const CAN_DELETE_PRIZE = 'can delete prize';
}
