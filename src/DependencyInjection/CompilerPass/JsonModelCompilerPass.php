<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle\DependencyInjection\CompilerPass;

use Doctrine\DBAL\Types\Type;
use Pfilsx\PostgreSQLDoctrine\DBAL\Type\JsonModelType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\AutowiringFailedException;
use Symfony\Component\DependencyInjection\Exception\LogicException;

final class JsonModelCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(Type::class)) {
            return;
        }

        $modelTypeIds = array_keys($container->findTaggedServiceIds('pfilsx.postgresql_doctrine_bundle.json_model_type'));

        $types = [];
        foreach ($modelTypeIds as $serviceId) {
            $className = $this->getTypeClassName($container, $serviceId);
            
            if ($className === null) {
                continue;
            }
            
            if (!is_subclass_of($className, JsonModelType::class)) {
                throw new LogicException('Json model type class should be a subclass of ' . JsonModelType::class);
            }
            $types[$className::getTypeName()] = $className;
        }

        if (count($types) === 0) {
            $container->removeDefinition('pfilsx.postgresql_doctrine_bundle.connection_wrapper');

            return;
        }

        $connectionWrapperDef = $container->getDefinition('pfilsx.postgresql_doctrine_bundle.connection_wrapper');
        $connectionWrapperDef
            ->setDecoratedService('doctrine.dbal.connection_factory')
            ->setArgument(1, $types)
        ;
    }

    private function getTypeClassName(ContainerBuilder $container, string $serviceId): ?string
    {
        if (class_exists($serviceId)) {
            return $serviceId;
        }

        $serviceDef = $container->getDefinition($serviceId);

        return $serviceDef->getClass();
    }
}