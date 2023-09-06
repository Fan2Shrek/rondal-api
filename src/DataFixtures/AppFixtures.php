<?php

namespace App\DataFixtures;

use App\Tests\Factory\ProductFactory;
use App\Tests\Factory\ProviderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProviderFactory::createMany(5);
        ProductFactory::createMany(15);
    }
}
