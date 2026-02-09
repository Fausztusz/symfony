<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Team;
use App\Enum\ProjectStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    private const int FAKE_PROJECTS = 5;
    public const string PROJECT_REFERENCE = 'ExampleProject';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $project = new Project;
        $project->setTitle('Example Project');
        $project->setDescription('This is a project description');
        $project->setStatus(ProjectStatus::ACTIVE);
        $project->setTeam($this->getReference(TeamFixtures::TEAM_REFERENCE, Team::class));

        $manager->persist($project);
        $this->addReference(self::PROJECT_REFERENCE, $project);

        for ($i = 0; $i < self::FAKE_PROJECTS; $i++) {
            $project = new Project;
            $project->setTitle($faker->words(3, true));
            $project->setDescription($faker->paragraph());
            $project->setStatus($faker->randomElement([ProjectStatus::PLANNED, ProjectStatus::ACTIVE, ProjectStatus::COMPLETED]));
            $project->setTeam($this->getReference(TeamFixtures::TEAM_REFERENCE, Team::class));

            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TeamFixtures::class,
        ];
    }
}
