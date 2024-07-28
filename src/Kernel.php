<?php

namespace App;

use App\DependencyInjection\Complier\ScraperResolverPass;
use App\DependencyInjection\RondalExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait {
        configureContainer as baseConfigureContainer;
    }

    protected function prepareContainer(ContainerBuilder $container): void
    {
        $container->registerExtension(new RondalExtension());

        parent::prepareContainer($container);
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        if ('test' !== $this->environment) {
            $container->import($this->getConfigDir().'/rondal.yaml');
        }

        $this->baseConfigureContainer($container, $loader, $builder);
    }

    protected function buildContainer(): ContainerBuilder
    {
        $container = parent::buildContainer();

        $container->addCompilerPass(new ScraperResolverPass());

        return $container;
    }
}
