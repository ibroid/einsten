<?php

use Symfony\Component\Translation\Exception\NotFoundResourceException;

require_once APPPATH . "utility/HttpResponse.php";

class Login extends CI_Controller
{
  use HttpResponse;

  public Eloquent $eloquent;

  public $redirectPage = [
    "Hakim" => "/hakim",
    "Panitera Pengganti" => "/panitera",
    "Panmud Gugatan" => "/panitera",
    "Panmud Permohonan" => "/panitera",
    "Panmud Hukum" => "/panitera",
    "Jurusita" => "/jurusita",
    "Kasir" => "/kasir",
    "Super Administrator" => "/admin"
  ];

  public function __construct()
  {
    parent::__construct();

    if ($this->input->method() !== "post") {
      show_404();
      exit;
    }

    $this->load->library("Eloquent");
    $this->eloquent->init()->loadModel();
  }

  public function index()
  {
    try {
      $user = $this->findUser();

      $this->load->library("SippLoginValidator", null, "sipp_login_validator");
      $storedKey = $this->sipp_login_validator->validation(
        array($user->code_activation, $this->input->post("password", true))
      );

      if ($storedKey !== $user->password) {
        throw new Exception("Password Salah");
      }

      $profile = $this->setSession($user);
      if (!isset($this->redirectPage[$profile->name])) {
        throw new Exception("Password Salah");
      }

      $this->response($this->redirectPage[$profile->name]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function findUser()
  {
    $sipp = $this->eloquent->capsule->connection("sipp");

    $user = $sipp->table("sys_users")
      ->select("password", "userid", "code_activation")->where(
        [
          "username" => $this->input->post("username", true)
        ]
      )->first();

    if (!$user) {
      throw new NotFoundResourceException("User tidak ditemukan");
    }

    return $user;
  }

  private function setSession($user)
  {
    $sipp =  $this->eloquent->capsule->connection("sipp");
    $user = $sipp->table('sys_users')

      ->leftJoin('sys_user_group', 'sys_users.userid', '=', 'sys_user_group.userid',)
      ->leftJoin('sys_groups', 'sys_user_group.groupid', '=', 'sys_groups.groupid')
      ->leftJoin('sys_user_online', 'sys_user_online.userid', '=', 'sys_users.userid')
      ->leftJoin('user_hakim', 'user_hakim.userid', '=', 'sys_users.userid')
      ->leftJoin('user_panitera', 'user_panitera.userid', '=', 'sys_users.userid')
      ->leftJoin('user_jurusita', 'user_jurusita.userid', '=', 'sys_users.userid')
      ->where('sys_users.userid', $user->userid)->first();

    $this->session->set_userdata('g_user_loged', $user);
    return $user;
  }
}
