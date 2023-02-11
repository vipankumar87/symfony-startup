<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 100; $i++) { 

            $user = new User();
            $user->setFullName($faker->name());
            $user->setEmail($faker->email());
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    'admin123'
                )
            );

            $user->setIsVerified(1);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
