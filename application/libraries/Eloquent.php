<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Eloquent
{
  public Capsule $capsule;

  public function init()
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
    ], 'sipp');

    $capsule->addConnection([
      'driver' => 'mysql',
      'host' => $_ENV["DB_HOST_EINSTEN"],
      'database' => $_ENV["DB_NAME_EINSTEN"],
      'username' => $_ENV["DB_USER_EINSTEN"],
      'password' => $_ENV["DB_PASS_EINSTEN"],
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]);

    $capsule->setEventDispatcher(new Dispatcher(new Container));

    $capsule->setAsGlobal();

    $capsule->bootEloquent();

    $this->capsule = $capsule;

    return $this;
  }

  public function loadModel()
  {
    $entity_path = APPPATH . 'models' . DIRECTORY_SEPARATOR;
    if (file_exists($entity_path)) {
      $this->_read_entity_dir($entity_path);
    }
  }

  private function _read_entity_dir($dirpath)
  {
    $ci = &get_instance();

    $handle = opendir($dirpath);
    if (!$handle) return;

    while (false !== ($filename = readdir($handle))) {
      if ($filename == "." or $filename == "..") {
        continue;
      }

      $filepath = $dirpath . $filename;
      if (is_dir($filepath)) {
        $this->_read_entity_dir($filepath);
      } elseif (strpos(strtolower($filename), '.php') !== false) {
        require_once $filepath;
      } else {
        continue;
      }
    }

    closedir($handle);
  }
}
