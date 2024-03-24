<?php

namespace App\DataFixtures;

use App\Entity\Data\ProductData;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ketchup = new Product('Ketchup', 'ketchup');

        $data = new ProductData($ketchup);
        $data->getInformations()->set('franprix-id', 99145086);
        $data->getInformations()->set('franprix-name', 'ketchup-flacon-top-down');
        $data->getInformations()->set('monoprix-id', 'MPX_3266125');
        $manager->persist($data);

        $mayo = new Product('mayonnaise', 'mayonnaise');
        $manager->persist($mayo);

        $data = new ProductData($mayo);
        $data->getInformations()->set('franprix-name', 'mayonnaise-de-dijon-flacon-top-down');
        $data->getInformations()->set('franprix-id', 99034507);
        $data->getInformations()->set('monoprix-id', 'MPX_3875532');
        $manager->persist($data);

        $manager->flush();
    }
}
