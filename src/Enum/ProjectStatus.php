<?php

namespace App\Enum;

class ProjectStatus extends EnumType
{
    protected string $name = 'ProjectStatus';
    protected array $values = [self::PLANNED, self::ACTIVE, self::COMPLETED];

    public const string PLANNED = 'PLANNED';
    public const string ACTIVE = 'ACTIVE';
    public const string COMPLETED = 'COMPLETED';
}
