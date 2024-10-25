<?php

class G_Controller extends CI_Controller
{
  public $redirectPage = [
    "Hakim" => "/hakim",
    "Panitera Pengganti" => "/panitera",
    "Panmud Gugatan" => "/panitera",
    "Panmud Permohonan" => "/panitera",
    "Panmud Hukum" => "/panitera",
    "Jurusita" => "/jurusita_jsp",
    "Kasir" => "/kasir",
    "Koordinator Delegasi" => "/delegasi",
    "Super Administrator" => "/admin"
  ];

  public Eloquent $eloquent;

  public stdClass $userdata;

  /**
   * @var	G_Loader
   */
  public $load;

  public function __construct()
  {
    parent::__construct();

    $this->load->library("Eloquent");
    $this->eloquent->init();
    $this->eloquent->loadModel();

    if ($this->session->userdata('g_user_loged') == null) {
      redirect("/");
      exit;
    }

    $this->userdata = $this->session->userdata('g_user_loged');
  }

  public function get_user_menu()
  {
    $accessableMenu = AccessableMenu::where("group_id", "=", $this->userdata->groupid)->get();
    return $accessableMenu;
  }
}
