<?php

namespace Softzino\EmployeeManagementApi\Enums;

enum EmploymentType: string
{
    case PERMANENT = 'permanent';
    case INTERN = 'intern';
    case PART_TIME = 'part_time';
    case CONTRACTUAL = 'contractual';
    case PROBATION = 'probation';
    case TEMPORARY = 'temporary';
}

