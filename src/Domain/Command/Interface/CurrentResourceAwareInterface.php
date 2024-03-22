<?php

namespace App\Domain\Command\Interface;

/**
 * @template T of object
 */
interface CurrentResourceAwareInterface
{
    /**
     * @param T $currentResource
     */
    public function setCurrentResource(object $currentResource): void;
}
