<?php
if (!defined('APP_ROOT')) define('APP_ROOT', dirname(dirname(__DIR__)));

return array(
    'environment'    => 'development',

    'mongo' => [
        'dbname'    => getenv('MONGO_DB_NAME'),
        'host'      => getenv('MONGO_PORT_27017_TCP_ADDR'),
        'port'      => getenv('MONGO_PORT_27017_TCP_PORT')
    ],
);