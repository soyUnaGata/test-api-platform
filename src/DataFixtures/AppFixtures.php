<?php

namespace App\DataFixtures;

use App\Entity\MistyTreasure;
use App\Factory\MistyTreasureFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(5);
        MistyTreasureFactory::createMany(30, function(){
            return [
                'owner' => UserFactory::random(),
            ];
        });
    }
}
