<?php

namespace Softzino\EmployeeManagementApi\Enums;

enum Religion: string
{
    case Islam = 'islam';
    case Christianity = 'christianity';
    case Hinduism = 'hinduism';
    case Buddhism = 'buddhism';
    case Sikhism = 'sikhism';
    case Other = 'other';
}
