<?php

namespace App\DTO;

final readonly class PaginatedResult
{
    public int $maxPage;
    public function __construct(
        public iterable $items,
        public int      $total,
        public int      $page,
        public int      $limit,
        public int      $lastPage,
    )
    {
        $this->maxPage = (int)ceil($this->total / $limit);
    }
}
