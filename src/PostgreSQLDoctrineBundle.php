<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle;

use Pfilsx\PostgreSQLDoctrine\DBAL\Type\JsonModelType;
use Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection\CompilerPass\JsonModelCompilerPass;
use Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection\CompilerPass\SchemaProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class PostgreSQLDoctrineBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container
            ->registerForAutoconfiguration(JsonModelType::class)
            ->addTag('pfilsx.postgresql_doctrine_bundle.json_model_type');

        $container->addCompilerPass(new SchemaProviderCompilerPass());
        $container->addCompilerPass(new JsonModelCompilerPass());
    }
}