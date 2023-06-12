<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class AppFixtures extends Fixture

{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // INSERT ROLES RANDOM
        for ($i = 0; $i < 30; $i++) {
            $userInsert = new User();
            $userInsert->setFirstName($faker->name());
            $userInsert->setLastName($faker->name());
            $userInsert->setEmail($faker->email());
            $userInsert->setPassword('test' . $i);

            $randomRole = rand(1, 10);
            if ($randomRole === 5 || $randomRole === 10) {
                $userInsert->setRoles(['ROLE_ADMIN']);
            } elseif ($randomRole === 7 || $randomRole === 4 || $randomRole === 8 || $randomRole === 2) {
                $userInsert->setRoles(['ROLE_PROF']);
            } else {
                $userInsert->setRoles(['ROLE_STUDENT']);
            }


            // $userInsert->setRoles($randomRole ===  ? ['ROLE_ADMIN'] : ['ROLE_STUDENT']);

            $manager->persist($userInsert);
        }

        $manager->flush();
    }
}
