<?php

class Logout extends CI_Controller
{
  public function index()
  {
    if ($this->session->method() != "post") {
      show_404();
      exit;
    }
    $this->session->sess_destroy();
    redirect("/");
  }
}
