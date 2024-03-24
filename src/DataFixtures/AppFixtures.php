<?php

namespace App\DataFixtures;

use App\Entity\Data\ProductData;
use App\Entity\Product;
use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Franprix
        $franprix = new Provider('Franprix', 'https://www.franprix.fr');
        $manager->persist($franprix);

        $adapter = new ProviderAdapter($franprix, '/courses/p/{name}-{id}');
        $manager->persist($adapter);

        $ketchup = new Product('Ketchup', 'ketchup');

        $data = new ProductData($ketchup);
        $data->getInformations()->set('franprix-id', 99145086);
        $data->getInformations()->set('franprix-name', 'ketchup-flacon-top-down');

        // Auchan
        // $auchan = new Provider('Auchan', 'https://www.auchan.fr/');
        // $manager->persist($auchan);

        // $adapter = new ProviderAdapter($auchan, '{name}/pr-{id}');
        // $manager->persist($adapter);

        // $ketchup->addData('auchan-id', 'C1235750');
        // $ketchup->addData('auchan-name', 'heinz-tomato-ketchup-flacon-souple');

        // //Leclrec
        // $leclerc = new Provider('Leclerc', 'https://www.e.leclerc');
        // $manager->persist($leclerc);

        // $adapter = new ProviderAdapter($leclerc, 'mag/e-leclerc-pont-sainte-maxence?code={id}');
        // $manager->persist($adapter);

        // $ketchup->addData('leclerc-id', "23G307G");

        // $manager->persist($ketchup);

        // $manager->flush();

        // Monop
        $monoprix = new Provider('Monoprix', 'https://courses.monoprix.fr');
        $manager->persist($monoprix);

        $adapter = new ProviderAdapter($monoprix, '/products/{id}/details');
        $manager->persist($adapter);

        $data->getInformations()->set('monoprix-id', 'MPX_3875532');

        $manager->persist($ketchup);

        $mayo = new Product('mayonnaise', 'mayonnaise');
        $manager->persist($mayo);

        $manager->persist($data);

        $data = new ProductData($mayo);
        $data->getInformations()->set('franprix-name', 'mayonnaise-de-dijon-flacon-top-down');
        $data->getInformations()->set('franprix-id', 99034507);
        $data->getInformations()->set('monoprix-id', 'MPX_3875532');

        $manager->persist($data);

        $manager->flush();
    }
}
