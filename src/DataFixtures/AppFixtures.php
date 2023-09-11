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
        $franprix = new Provider('Franprix', 'https://www.franprix.fr');
        $manager->persist($franprix);

        $adapter = new ProviderAdapter($franprix, '/courses/p/{name}-{id}');
        $manager->persist($adapter);

        $ketchup = new Product('Ketchup', 'ketchup');
        $ketchup->addData('franprix-id', 99073109);
        $ketchup->addData('franprix-name', 'ketchup-flacon-top-down');

        $auchan = new Provider('Auchan', 'https://www.auchan.fr/');
        $manager->persist($auchan);

        $adapter = new ProviderAdapter($auchan, '{name}/pr-{id}');
        $manager->persist($adapter);

        $ketchup->addData('auchan-id', 'C1235750');
        $ketchup->addData('auchan-name', 'heinz-tomato-ketchup-flacon-souple');
        $manager->persist($ketchup);

        $manager->flush();
    }
}
