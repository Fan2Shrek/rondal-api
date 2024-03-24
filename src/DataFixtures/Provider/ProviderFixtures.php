<?php

namespace App\DataFixtures\Provider;

use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProviderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $provider = new Provider($data['name'], $data['url']);
            $manager->persist($provider);

            $adapter = new ProviderAdapter($provider, $data['adapter']);
            $manager->persist($adapter);
        }

        $manager->flush();
    }

    /**
     * @return iterable<array{name: string, url: string, adapter: string}>
     */
    private function getData(): iterable
    {
        yield ['name' => 'Franprix', 'url' => 'https://www.franprix.fr', 'adapter' => '/courses/p/{name}-{id}'];
        yield ['name' => 'Monoprix', 'url' => 'https://courses.monoprix.fr', 'adapter' => '/products/{id}/details'];
    }
}
