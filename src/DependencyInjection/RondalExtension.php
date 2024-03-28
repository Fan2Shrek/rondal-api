<?php

namespace App\DependencyInjection;

use App\Repository\ProviderRepository;
use App\Scraper\AbstractProviderScraper;
use App\Scraper\Evaluator\ScrapEvaluator;
use App\Scraper\Factory\ScraperFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class RondalExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configurator();
        $configs = $this->processConfiguration($configuration, $configs);

        $scrapEvaluator = new Definition(ScrapEvaluator::class);
        $container->setDefinition('rondal.scraper_evaluator', $scrapEvaluator);

        $factory = new Definition(ScraperFactory::class);
        $factory
            ->setArguments([
                new Reference('event_dispatcher'),
                new Reference(ProviderRepository::class),
            new Reference('rondal.scraper_evaluator'),
            ]);

        $container->setDefinition(ScraperFactory::class, $factory);
        $container->setAlias('rondal.scraper_factory', ScraperFactory::class);

        foreach ($configs['scrapers'] as $class => $providerName) {
            if (!class_exists($class) || !is_subclass_of($class, AbstractProviderScraper::class)) {
                throw new \InvalidArgumentException(sprintf('Invalid class "%s" as a scrapper.', $class));
            }

            $definition = new Definition($class);
            $definition
                ->addTag('rondal.scraper', ['provider' => $providerName])
                ->setFactory([new Reference('rondal.scraper_factory'), 'create'])
                ->setArguments([$class, $providerName]);

            if ($configs['all']['track']) {
                $definition->addArgument(true);
            }

            $container->setDefinition($class, $definition);
        }
    }
}
