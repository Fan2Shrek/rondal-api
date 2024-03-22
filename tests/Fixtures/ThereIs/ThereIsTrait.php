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

        ThereIs::setContainer(self::getContainer());
    }
}
