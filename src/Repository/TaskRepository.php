<?php

namespace App\Repository;

use App\Entity\Task;
use App\Enum\TaskStatus;
use App\Traits\Paginate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    use Paginate;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return array Returns an array of Task objects
     */
    public function findByProjectGroupedByStatus(int $value): array
    {
        $tasks = $this->createQueryBuilder('t')
            ->andWhere('t.project = :val')
            ->setParameter('val', $value)
            ->orderBy('t.status', 'ASC')
            ->getQuery()
            ->getResult();

        return array_reduce($tasks, function (array $result, Task $task) {
            $result[$task->getStatus()][] = $task;
            return $result;
        }, [TaskStatus::TODO => [], TaskStatus::IN_PROGRESS => [], TaskStatus::DONE => []]);
    }
}
