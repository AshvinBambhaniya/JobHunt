<?php

namespace App\Enums;

enum JobType: string
{
    case Remote = 'remote';
    case Onsite = 'onsite';
    case Hybrid = 'hybrid';
}
