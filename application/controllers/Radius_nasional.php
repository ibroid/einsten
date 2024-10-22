<?php


class Radius_nasional extends G_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->service("RadiusService");
  }
  public function index()
  {
    $this->load
      ->css_addon([base_url(LocalResource::DATATABLE_CSS)])
      ->js_plugin([
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::DATATABLE_JS),
        PublicResource::FLATPICKR_JS,
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Radius Nasional"
      ])
      ->page("radius_nasional_page");
  }

  public function datatable()
  {
    $this->RadiusService->datatable();
  }
}
