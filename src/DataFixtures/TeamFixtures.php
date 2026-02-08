<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TeamFixtures extends Fixture
{
    public const string TEAM_REFERENCE = 'teamA';
    private const int FAKE_TEAMS = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $team = new Team();
        $team->setName('Team A');
        $team->setDescription('The coolest team');
        $team->addMember($this->getReference(UserFixtures::ADMIN_USER_REFERENCE, User::class));

        $manager->persist($team);
        $this->addReference(self::TEAM_REFERENCE, $team);

        for ($i = 0; $i < self::FAKE_TEAMS; $i++) {
            $team = new Team();
            $team->setName('Team ' . $faker->word);
            $team->setDescription($faker->randomElement([$faker->sentence(), $faker->paragraph()]));
            $team->addMember($this->getReference(UserFixtures::ADMIN_USER_REFERENCE, User::class));

            $manager->persist($team);
        }
        $manager->flush();
    }
}
