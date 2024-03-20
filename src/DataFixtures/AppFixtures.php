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
        // Franprix
        $franprix = new Provider('Franprix', 'https://www.franprix.fr');
        $manager->persist($franprix);

        $adapter = new ProviderAdapter($franprix, '/courses/p/{name}-{id}');
        $manager->persist($adapter);

        $ketchup = new Product('Ketchup', 'ketchup');
        $ketchup->addData('franprix-id', 99073109);
        $ketchup->addData('franprix-name', 'ketchup-flacon-top-down');

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
        // $monoprix = new Provider('Monoprix', 'https://www.monoprix.fr');
        // $manager->persist($monoprix);

        // $adapter = new ProviderAdapter($monoprix, '/courses/{name}-{id}-p');
        // $manager->persist($adapter);

        // $ketchup->addData('monoprix-id', 3266125);
        // $ketchup->addData('monoprix-name', 'tomato-ketchup-heinz');

        $manager->persist($ketchup);

        $mayo = new Product('mayonnaise', 'mayonnaise');
        $mayo->addData('franprix-name', 'mayonnaise-de-dijon-flacon-top-down')
            ->addData('franprix-id', 99034507)

            ->addData('monoprix-name', 'mayonnaise-de-dijon-amora')
            ->addData('monoprix-id', 3267619);

        $manager->persist($mayo);

        $manager->flush();
    }
}
