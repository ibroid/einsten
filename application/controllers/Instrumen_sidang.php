<?php

class Instrumen_sidang extends G_Controller
{
  public function index()
  {
    $this->load
      ->js_plugin([
        base_url('assets/js/vue/dist/vue.global.prod.js'),
        base_url('assets/js/sweetalert2/dist/sweetalert2.all.min.js'),
        base_url('assets/js/moment/moment.js'),
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Panitera"
      ])
      ->page("instrumen_sidang_page");
  }
}
