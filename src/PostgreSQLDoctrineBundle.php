<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle;

use Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection\CompilerPass\SchemaProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class PostgreSQLDoctrineBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new SchemaProviderCompilerPass());
    }
}