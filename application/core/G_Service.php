<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CI_Service Core Class
 *
 * Class ini akan menjadi parent class dari semua service yang kamu buat.
 */
class G_Service
{

  // public Eloquent $eloquent;

  public function __construct()
  {
    $this->load->library('Eloquent', 'eloquent');
  }

  /**
   * Magic method __get
   *
   * Mengambil instance CI dan memberikan akses ke semua resource CI
   */
  public function __get($key)
  {
    // Mengambil instance CodeIgniter dan memberikan akses ke properti CI
    return get_instance()->$key;
  }
}
