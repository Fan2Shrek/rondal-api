<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configurator implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('rondal');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('all')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('track')->defaultValue(true)->end()
                    ->end()
                ->end()
            ->end()
        ;

        /** @todo maybe there is a better way to validate this */
        $rootNode
            ->children()
                ->arrayNode('scrapers')
                    ->isRequired()
                    ->useAttributeAsKey('class')
                    ->prototype('variable')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
