<?php

class Panitera extends G_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->userdata->panitera_id == null) {
      redirect('/');
    }
  }

  public function index()
  {
    $this->load
      ->js_plugin([base_url('/assets/js/jquery.slim.js')])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Panitera"
      ])
      ->page("panitera_page");
  }
}
