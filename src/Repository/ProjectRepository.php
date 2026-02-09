<?php

namespace App\Repository;

use App\DTO\PaginatedResult;
use App\Entity\Project;
use App\Traits\Paginate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{

    use Paginate;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @return Project[] Returns an array of Project objects
     */
    public function getProjectStatistics(int $teamID): array
    {
        return $this->createQueryBuilder('p')
            ->select(['p.status', 'COUNT(p.status) AS count'])
            ->andWhere('p.team = :val')
            ->setParameter('val', $teamID)
            ->groupBy('p.status')
            ->getQuery()
            ->getResult();
    }
}
