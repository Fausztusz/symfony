<?php

namespace App\Enum;

enum ProjectStatus: string
{
    case PLANNED = 'PLANNED';
    case ACTIVE = 'ACTIVE';
    case COMPLETED = 'COMPLETED';
}
