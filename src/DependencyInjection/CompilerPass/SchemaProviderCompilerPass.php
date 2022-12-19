<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection\CompilerPass;

use Doctrine\Migrations\Provider\SchemaProvider;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('doctrine.migrations.entity_manager_registry_loader')) {
            return;
        }

        $definition = $container->getDefinition('pfilsx.postgresql_doctrine_bundle.schema_provider');

        $definition->setArgument(0, new Reference('doctrine.migrations.entity_manager_registry_loader'));

        $diDefinition = $container->getDefinition('doctrine.migrations.dependency_factory');

        $diDefinition->addMethodCall('setDefinition', [
            SchemaProvider::class,
            new ServiceClosureArgument(new Reference('pfilsx.postgresql_doctrine_bundle.schema_provider'))
        ]);
    }
}