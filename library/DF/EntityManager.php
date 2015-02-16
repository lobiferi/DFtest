<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DF;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Portability\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;
use PhSpring\Annotations\Config;
use ReflectionClass;

#use const APPLICATION_PATH;

/**
 * Description of EntityManager
 *
 * @author lobiferi
 */
class EntityManager extends DoctrineEntityManager {

    /**
     * @Config("doctrine")
     */
    private $conf;

    public function __construct() {
        $config = new Configuration();
        if (empty($this->conf->cache)) {
            $cache = new ArrayCache();
        } else {
            $clazz = $this->conf->cache;
            $cache = new $clazz();
        }
        $config->setProxyDir(APPLICATION_PATH . '/persistent/Proxies');
        $config->setProxyNamespace('Proxies');

        $config->setAutoGenerateProxyClasses((APPLICATION_ENV == "development"));
        AnnotationRegistry::registerFile((new ReflectionClass(AnnotationDriver::class))->getFileName());
        $reader = new AnnotationReader();
        $driverImpl = new AnnotationDriver($reader, array(APPLICATION_PATH . "/persistent/Entities"));
        $config->setMetadataDriverImpl($driverImpl);

        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $conn = array(
            'dbname' => $this->conf->dbname,
            'user' => $this->conf->user,
            'password' => $this->conf->password,
            'host' => $this->conf->host,
            'driver' => $this->conf->driver,
        );
        $eventManager = null;

        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        switch (true) {
            case (is_array($conn)):
                $conn = DriverManager::getConnection(
                                $conn, $config, ($eventManager ? : new EventManager())
                );
                break;

            case ($conn instanceof Connection):
                if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                    throw ORMException::mismatchedEventManager();
                }
                break;

            default:
                throw new InvalidArgumentException("Invalid argument: " . $conn);
        }

        parent::__construct($conn, $config, $conn->getEventManager());
    }

}
