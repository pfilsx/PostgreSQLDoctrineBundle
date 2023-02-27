<?php

declare(strict_types=1);

namespace Pfilsx\PostgreSQLDoctrineBundle;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Pfilsx\PostgreSQLDoctrine\DBAL\Type\JsonModelTypeRegistry;
use Symfony\Component\Serializer\Debug\TraceableNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

class JsonModelConnectionFactoryDecorator extends ConnectionFactory
{
    private ConnectionFactory $innerFactory;
    private array $typesMap;
    private null|AbstractObjectNormalizer|TraceableNormalizer $objectNormalizer;

    private bool $initialized = false;

    public function __construct(ConnectionFactory $innerFactory, array $typesMap = [], null|AbstractObjectNormalizer|TraceableNormalizer $objectNormalizer = null)
    {
        $this->innerFactory = $innerFactory;
        $this->typesMap = $typesMap;
        $this->objectNormalizer = $objectNormalizer;
    }

    public function createConnection(array $params, ?Configuration $config = null, ?EventManager $eventManager = null, array $mappingTypes = []): Connection
    {
        if (!$this->initialized) {
            $this->initializeTypes();
        }

        return $this->innerFactory->createConnection($params, $config, $eventManager, $mappingTypes);
    }
    
    private function initializeTypes(): void
    {
        if ($this->objectNormalizer !== null) {
            JsonModelTypeRegistry::setObjectNormalizer($this->objectNormalizer);
        }
        foreach ($this->typesMap as $name => $className) {
            JsonModelTypeRegistry::addType($name, $className, true);
        }

        JsonModelTypeRegistry::registerTypes();

        $this->initialized = true;
    }
}