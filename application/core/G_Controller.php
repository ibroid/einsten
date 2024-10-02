<?php

class G_Controller extends CI_Controller
{
  public Eloquent $eloquent;

  public array $userdata;

  public function __construct()
  {
    parent::__construct();

    $this->load->library("Eloquent");

    $this->userdata = $this->session->userdata('g_user_loged');
  }
}
