<?php

namespace Softzino\EmployeeManagementApi\Enums;

enum JobType: string
{
    case ONSITE = 'onsite';
    case REMOTE = 'remote';
    case HYBRID = 'hybrid';
}
