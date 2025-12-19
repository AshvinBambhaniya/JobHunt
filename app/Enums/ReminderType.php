<?php

namespace App\Enums;

enum ReminderType: string
{
    case MANUAL = 'manual';
    case AUTO_FOLLOW_UP = 'auto_follow_up';
    case INTERVIEW = 'interview';
}
