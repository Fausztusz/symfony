<?php

namespace App\Enum;

class TaskStatus extends EnumType
{
    protected string $name = 'TaskStatus';
    protected array $values = [self::TODO, self::IN_PROGRESS, self::DONE];
    public const string TODO = 'TODO';
    public const string IN_PROGRESS = 'IN_PROGRESS';
    public const string DONE = 'DONE';
}
