<?php

namespace App\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class EnumType extends Type
{
    protected string $name {
        get {
            return $this->name;
        }
    }
    protected array $values = [];

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $values = array_map(fn($val) => "'" . $val . "'", $this->values);
        return "ENUM(" . implode(", ", $values) . ")";
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (!in_array($value, $this->values, true)) {
            throw new \InvalidArgumentException("Invalid '" . $this->name . "' value.");
        }
        return $value;
    }
}
