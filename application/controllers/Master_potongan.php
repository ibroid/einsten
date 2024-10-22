<?php

class Master_potongan extends G_Controller
{
  public JurnalKeuanganService $jurnalKeuangan;

  public function __construct()
  {
    parent::__construct();

    $this->load->service("JurnalKeuanganService", null, "jurnalKeuangan");
  }

  private function validation()
  {
    $this->load->library('form_validation');
    $this->load->helper('security');

    $this->form_validation->set_rules(
      'nama_radius',
      'Nama Radius',
      'required|xss_clean|min_length[3]'
    );

    $this->form_validation->set_rules(
      'filter_key',
      'Kata Kunci Pembeda',
      'xss_clean|min_length[3]'
    );

    $this->form_validation->set_rules(
      'jumlah_jurnal',
      'Jumlah Jurnal',
      'required|xss_clean'
    );

    $this->form_validation->set_rules(
      'jumlah_jurusita',
      'Jumlah Jurusita',
      'required|xss_clean'
    );

    $this->form_validation->set_rules(
      'jumlah_kantor',
      'Jumlah Kantor',
      'required|xss_clean'
    );

    $this->form_validation->set_rules(
      'berlaku_dari',
      'Berlaku Dari',
      'required|xss_clean'
    );

    $this->form_validation->set_rules(
      'berlaku_sampai',
      'Berlaku Sampai',
      'required|xss_clean'
    );

    return $this->form_validation->run();
  }

  public function index()
  {
    $this->load
      ->css_addon([PublicResource::FLATPICKR_CSS])
      ->js_plugin([
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::HTMX),
        PublicResource::FLATPICKR_JS,
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Master Potongan"
      ])
      ->page("master_potongan_page", [
        "data" => PotonganJurnal::all(),
        "potongan" => $this->jurnalKeuangan->potonganBerlaku()
      ]);
  }

  public function tambah()
  {
    G_Input::mustPost();

    try {
      if (!$this->validation()) {
        throw new Exception(validation_errors());
      }

      $this->jurnalKeuangan->simpanPotonganBaru(request());

      if ($this->input->request_headers('Hx-Request') == true) {
        header("HX-Refresh: true");
        echo "ok";
      }
    } catch (\Throwable $th) {
      echo validation_errors();
      if ($this->input->request_headers('Hx-Request') == true) {
        echo $th->getMessage();
        exit;
      }
      throw $th;
    }
  }
}
