<?php

namespace App\Domain\Command\Interface;

/**
 * @template T of object
 */
interface CurrentResourceAwareInterface
{
    /**
     * @return T
     */
    public function getCurrentResource(): object;

    /**
     * @param T $currentResource
     */
    public function setCurrentResource(object $currentResource): void;
}
