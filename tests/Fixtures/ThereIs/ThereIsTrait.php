<?php

namespace App\Tests\Fixtures\ThereIs;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

trait ThereIsTrait
{
    /**
     * @before
     */
    public function initThereIs(): void
    {
        assert($this instanceof KernelTestCase, 'This trait can only be used in a KernelTestCase');

        if (!static::$booted) {
            static::bootKernel();
        }

        ThereIs::setContainer(static::getContainer());
    }
}
