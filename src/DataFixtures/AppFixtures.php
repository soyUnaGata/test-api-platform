<?php

namespace App\DataFixtures;

use App\Entity\MistyTreasure;
use App\Factory\MistyTreasureFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       MistyTreasureFactory::createMany(30);
    }
}
