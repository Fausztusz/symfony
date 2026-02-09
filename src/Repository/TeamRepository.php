<?php

namespace App\Repository;

use App\Entity\Team;
use App\Traits\Paginate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    use Paginate;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

        /**
         * @return Team[] Returns an array of Team objects
         */
    public function getTeamStatistics(int $teamID): array
    {
        return $this->createQueryBuilder('team')
            ->select(['task.status', 'COUNT(task.status) as count'])
            ->join('team.projects', 'p')
            ->join('p.tasks', 'task')
            ->andWhere('team.id = :val')
            ->groupBy('task.status')
            ->setParameter('val', $teamID)
            ->getQuery()
            ->getResult();
    }

}
