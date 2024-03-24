<?php

namespace App\Tests\Functional\Trait;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

trait EntityTrait
{
    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    public function getLastEntity(string $class): object
    {
        assert($this instanceof KernelTestCase, 'This trait can only be used in a KernelTestCase');

        $em = self::getContainer()->get('doctrine')->getManager();
        $repository = $em->getRepository($class);

        return $repository->findOneBy([], ['id' => 'desc']);
    }
}
