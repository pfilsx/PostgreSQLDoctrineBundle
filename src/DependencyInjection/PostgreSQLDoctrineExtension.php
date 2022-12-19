<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class PostgreSQLDoctrineExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $locator = new FileLocator(__DIR__ . '/../Resources/config/');
        $loader = new XmlFileLoader($container, $locator);

        $loader->load('services.xml');
    }
}