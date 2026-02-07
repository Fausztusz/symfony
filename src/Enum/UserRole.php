<?php

namespace App\Enum;

class UserRole extends EnumType
{
    protected string $name = 'UserRole';
    protected array $values = [self::ADMIN, self::MEMBER];
    public const string ADMIN = 'ADMIN';
    public const string MEMBER = 'MEMBER';
}
