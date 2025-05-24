<?php

namespace App\Enums;

enum JobType: string
{
    case ONSITE = 'onsite';
    case REMOTE = 'remote';
    case HYBRID = 'hybrid';
}
