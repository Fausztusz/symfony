<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const string ADMIN_USER_REFERENCE = 'admin-user';
    private const int FAKE_USERS = 10;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $userAdmin = new User;
        $userAdmin->setEmail('admin@test.com');

        $adminPassword = $this->passwordHasher->hashPassword(
            $userAdmin,
            'password'
        );
        $userAdmin->setPassword($adminPassword);
        $userAdmin->setRole(UserRole::ADMIN);

        $manager->persist($userAdmin);

        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);

        for ($i = 0; $i < self::FAKE_USERS; $i++) {
            $user = new User;
            $user->setEmail($faker->safeEmail());
            $userPassword = $this->passwordHasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($userPassword);
            $user->setRole($faker->randomElement([UserRole::ADMIN, UserRole::MEMBER, UserRole::MEMBER, UserRole::MEMBER]));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
