<?php

namespace App\DependencyInjection;

use App\Repository\ProviderRepository;
use App\Scraper\Factory\ScraperFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class RondalExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $mergedConfig = [];

        foreach ($configs as $item) {
            foreach ($item as $key => $value) {
                $mergedConfig[$key] = array_merge($mergedConfig[$key] ?? [], $value);
            }
        }

        $configs = $configs[0];

        $factory = new Definition(ScraperFactory::class);
        $factory
            ->setArguments([
                new Reference('event_dispatcher'),
                new Reference(ProviderRepository::class),
            ]);

        $container->setDefinition(ScraperFactory::class, $factory);
        $container->setAlias('rondal.scraper_factory', ScraperFactory::class);

        foreach ($configs['scrapers'] as $class => $providerName) {
            $definition = new Definition($class);
            $definition
                ->addTag('rondal.scraper', ['provider' => $providerName])
                ->setFactory([new Reference('rondal.scraper_factory'), 'create'])
                ->setArguments([$class, $providerName]);

            $container->setDefinition($class, $definition);
        }
    }
}
