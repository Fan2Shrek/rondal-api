<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use App\Tests\Factory\ProductFactory;
use App\Tests\Factory\ProviderFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $franprix = new Provider('franprix', 'https://www.franprix.fr/');
        $manager->persist($franprix);

        $adapter = new ProviderAdapter($franprix, 'course.p/{product}-{id}');
        $manager->persist($adapter);

        $ketchup = new Product('ketchup', 'ketchup');
        $ketchup->addData('franprix-id', 99073109);
        $manager->persist($ketchup);

        $manager->flush();
    }
}
