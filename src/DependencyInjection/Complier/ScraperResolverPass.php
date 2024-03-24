<?php

namespace App\DependencyInjection\Complier;

use App\Scraper\Resolver\ScraperResolver;
use App\Scraper\Resolver\ScraperResolverInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ScraperResolverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has(ScraperResolverInterface::class)) {
            $container->removeDefinition(ScraperResolverInterface::class);
        }

        $definition = new Definition(ScraperResolverInterface::class);
        $definition
            ->setClass(ScraperResolver::class)
            ->setArguments([
                new TaggedIterator('rondal.scraper'),
            ]);

        $container->setDefinition(ScraperResolverInterface::class, $definition);
    }
}
