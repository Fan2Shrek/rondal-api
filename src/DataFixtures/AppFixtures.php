<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $franprix = new Provider('franprix', 'https://www.franprix.fr');
        $manager->persist($franprix);

        $adapter = new ProviderAdapter($franprix, '/courses/p/{name}-{id}');
        $manager->persist($adapter);

        $ketchup = new Product('ketchup', 'ketchup');
        $ketchup->addData('franprix-id', 99073109);
        $ketchup->addData('franprix-name', 'ketchup-flacon-top-down');
        $manager->persist($ketchup);

        $manager->flush();
    }
}
