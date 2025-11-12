<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!function_exists("sysconf")) {

  function sysconf()
  {
    $capsule = new Capsule;

    $capsule->addConnection([
      'driver' => 'mysql',
      'host' => $_ENV["DB_HOST_SIPP"],
      'database' => $_ENV["DB_NAME_SIPP"],
      'username' => $_ENV["DB_USER_SIPP"],
      'password' => $_ENV["DB_PASS_SIPP"],
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]);
    $capsule->setAsGlobal();
    $rawDataSysConf = $capsule->table("sys_config")->get();

    $obj = new stdClass;

    foreach ($rawDataSysConf as $key => $value) {
      $obj->{$value->name} = $value->value;
    }

    return $obj;
  }
}
