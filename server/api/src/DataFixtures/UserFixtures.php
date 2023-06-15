<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public static array $api_users = [
        // admin username
        ['Role', 'Admin', 'admin@admin.com', 'roleadmin', 'ROLE_ADMIN'],
        ['Role', 'Prof', 'professor@prof.com', 'roleprof', 'ROLE_PROF'],
    ];


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // INSERT ROLES TEAM SALINE
        // $i = 0;
        // if (!empty(self::$api_users)) {
        //     foreach (self::$api_users as $api_user) {
        //         $userRole = new User();
        //         $userRole->setFirstName($api_user[0]);
        //         $userRole->setLastName($api_user[1]);
        //         $userRole->setEmail($api_user[2]);
        //         $userRole->setPassword($api_user[3]);
        //         $userRole->setRoles([$api_user[4]]);


        // for($j= 0; $j < 5; $j++) {
        //     $userRole->setFirstName($faker->name());
        //     $userRole->setLastName($faker->name());
        //     $userRole->setEmail($faker->email());
        //     $userRole->setPassword('rolestudent');
        //     $userRole->setRoles(['ROLE_STUDENT']);
        // }
        //         $manager->persist($userRole);
        //         ++$i;
        //     }
        // }
        // $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }
}
