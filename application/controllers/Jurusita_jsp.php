<?php

class Jurusita_jsp extends G_Controller
{
  public function index()
  {
    $this->load
      ->js_plugin([
        base_url('/assets/js/jquery.slim.js'),
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Jurusita"
      ])
      ->page("jurusita_page");
  }

  public function instrumen_diterima()
  {
    $this->load
      ->js_plugin([
        base_url('/assets/js/jquery.slim.js'),
        base_url(LocalResource::SWEETALERT2),
        base_url(LocalResource::VUE_PROD),
        base_url(LocalResource::MOMENT)
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Jurusita"
      ])
      ->page("instrumen_diterima_page");
  }
}
