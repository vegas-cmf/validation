<?php
/**
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * Date: 4/24/14
 * Time: 1:24 PM
 */

date_default_timezone_set('UTC');

//Test Suite bootstrap
include __DIR__ . "/../vendor/autoload.php";

define('TESTS_ROOT_DIR', dirname(__FILE__));

$configArray = require_once dirname(__FILE__) . '/fixtures/app/config/config.php';

$config = new \Phalcon\Config($configArray);

// \Phalcon\Mvc\Collection requires non-static binding of service providers.
class DiProvider
{

    public function resolve(\Phalcon\Config $config)
    {
        $di = new \Phalcon\Di\FactoryDefault();

        $di->set('config', $config, true);

        $di->set('mongo', function() use ($config) {
            $connectionString = "mongodb://{$config->mongo->host}:{$config->mongo->port}";
            $mongo = new \MongoClient($connectionString);
            return $mongo->selectDb($config->mongo->dbname);
        }, true);

        $di->set('collectionManager', function() {
            return new \Phalcon\Mvc\Collection\Manager();
        }, true);

        \Phalcon\Di::setDefault($di);
    }

}

(new \DiProvider)->resolve($config);