<?php

namespace App\Twig\Components;

use App\DTO\PaginatedResult;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Table
{
    public PaginatedResult $data;
    public string $indexRoute;
    public iterable $columns;
}
