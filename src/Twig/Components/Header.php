<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Header')]
final class Header
{
    public ?string $title = 'Task Manager';
}
