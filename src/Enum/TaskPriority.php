<?php

namespace App\Enum;

class TaskPriority extends EnumType
{

    protected string $name = 'TaskPriority';
    protected array $values = [self::LOW, self::MEDIUM, self::HIGH];
    public const string LOW = 'LOW';
    public const string MEDIUM = 'MEDIUM';
    public const string HIGH = 'HIGH';
}
