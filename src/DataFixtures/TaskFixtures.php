<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    private const int FAKE_TASKS = 15;


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::FAKE_TASKS; $i++) {
            $task = new Task;
            $task->setTitle($faker->words(3, true));
            $task->setDescription($faker->paragraph());
            $task->setStatus($faker->randomElement([TaskStatus::TODO, TaskStatus::DONE, TaskStatus::IN_PROGRESS]));
            $task->setPriority($faker->randomElement([TaskPriority::LOW, TaskPriority::MEDIUM, TaskPriority::HIGH]));
            $task->setDueDate($faker->randomElement([null, $faker->dateTimeBetween('now', '+1 years')]));
            $task->setAssignee($faker->randomElement([null, $this->getReference(UserFixtures::ADMIN_USER_REFERENCE, User::class)]));
            $task->setProject($this->getReference(ProjectFixtures::PROJECT_REFERENCE, Project::class));

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProjectFixtures::class,
        ];
    }
}
