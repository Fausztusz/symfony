<?php

namespace App\Traits;

use App\DTO\PaginatedResult;
use Doctrine\ORM\Tools\Pagination\Paginator;

trait Paginate
{
    public function paginate(int $page = 1, int $limit = 10): PaginatedResult
    {
        $page = max($page, 1);
        $limit = min(100, max($limit, 1));

        $query = $this->createQueryBuilder('model')
            ->orderBy('model.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query, true);
        $lastPage = (int)ceil($paginator->count() / $limit);

        return new PaginatedResult(
            $paginator,
            $paginator->count(),
            $page,
            $limit,
            $lastPage,
        );
    }
}
