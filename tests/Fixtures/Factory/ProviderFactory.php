<?php

namespace App\Tests\Fixtures\Factory;

use App\Entity\Provider;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Provider>
 */
final class ProviderFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->company(),
            'url' => self::faker()->url(),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Provider $provider): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Provider::class;
    }
}
