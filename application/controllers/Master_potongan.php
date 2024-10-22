<?php

class Master_potongan extends G_Controller
{
  public function index()
  {
    $this->load
      ->css_addon([PublicResource::FLATPICKR_CSS, LocalResource::DATATABLE_CSS])
      ->js_plugin([
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::DATATABLE_CSS),
        base_url(LocalResource::HTMX),
        PublicResource::FLATPICKR_JS,
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Master Potongan"
      ])
      ->page("master_potongan_page", [
        "data" => PotonganJurnal::all()
      ]);
  }
}
