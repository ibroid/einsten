<?php


class Hakim extends G_Controller
{
  public function index()
  {
    $this->load->js_plugin([
      base_url('/assets/js/jquery.slim.js')
    ])->template("template")->page("panitera_page");
  }
}
