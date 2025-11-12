<?php

require_once './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST_EINSTEN'],
            'name' => $_ENV['DB_NAME_EINSTEN'],
            'user' => $_ENV['DB_USER_EINSTEN'],
            'pass' => $_ENV['DB_PASS_EINSTEN'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST_EINSTEN'],
            'name' => $_ENV['DB_NAME_EINSTEN'],
            'user' => $_ENV['DB_USER_EINSTEN'],
            'pass' => $_ENV['DB_PASS_EINSTEN'],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST_EINSTEN'],
            'name' => $_ENV['DB_NAME_EINSTEN'],
            'user' => $_ENV['DB_USER_EINSTEN'],
            'pass' => $_ENV['DB_PASS_EINSTEN'],
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
