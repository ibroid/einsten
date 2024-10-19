<?php

class Instrumen_sidang extends G_Controller
{
  public InstrumenService $instrumenService;
  public PerkaraService $perkaraService;
  public JurusitaService $jurusitaService;

  public function __construct()
  {
    parent::__construct();

    $this->load->css_addon([
      base_url(LocalResource::DATATABLE_CSS),
      PublicResource::FLATPICKR_CSS
    ]);

    $this->load->service('InstrumenService', null, 'instrumenService');
    $this->load->service('PerkaraService', null, 'perkaraService');
    $this->load->service('JurusitaService', null, 'jurusitaService');
  }

  private function validation()
  {
    $this->load->library('form_validation');
    $this->load->helper('security');

    $this->form_validation->set_rules(
      'sidang_id',
      'ID Sidang',
      'trim|required|max_length[12]|xss_clean'
    );

    $this->form_validation->set_rules(
      'jurusita_id',
      'ID Jurusita',
      'trim|required|max_length[12]|xss_clean'
    );

    $this->form_validation->set_rules(
      'perkara_id',
      'ID Perkara',
      'trim|required|max_length[12]|xss_clean'
    );

    $this->form_validation->set_rules(
      'jenis_panggilan',
      'Jenis Panggilan',
      'required|xss_clean|max_length[64]'
    );

    $this->form_validation->set_rules(
      'kode_panggilan',
      'Kode Panggilan',
      'required|xss_clean|max_length[3]|trim'
    );

    $this->form_validation->set_rules(
      'tanggal_sidang',
      'Tanggal Sidang',
      'required|xss_clean|max_length[64]'
    );

    return $this->form_validation->run();
  }


  public function index()
  {
    $panitera_id = $this->userdata->panitera_id;
    $this->load
      ->js_plugin([
        base_url(LocalResource::VUE_PROD),
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::SWEETALERT2),
        base_url(LocalResource::MOMENT),
        base_url(LocalResource::DATATABLE_JS),
        base_url(LocalResource::HTMX),
        PublicResource::FLATPICKR_JS,
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Panitera"
      ])
      ->page("instrumen_page");
  }

  public function tbody_tundaan_sidang()
  {
    $perkaraSidangDitunda = $this->instrumenService->perkaraSidangDitunda($this->userdata->panitera_id);

    header("HX-Trigger-After-Swap: datatableInit");

    echo $this->load->component("panitera/tbody_tundaan_sidang", [
      "perkara_ditunda" => $perkaraSidangDitunda,
      "instrumen_hari_ini" => $this->instrumenService->today()
    ]);
  }

  public function form_tundaan()
  {
    G_Input::mustPost();
    $perkara = Perkara::findOrFail(request('perkara_id'));

    $targetSidang = JadwalSidang::where('perkara_id', $perkara->perkara_id)->whereDate('tanggal_sidang', request('target_tanggal_sidang'))->first();

    header('HX-Trigger-After-Swap: datepickerInit');

    $perkaraJurusita = $this->jurusitaService->perkaraJurusita($perkara->perkara_id);

    echo $this->load->component("panitera/form_instrumen_tundaan", [
      "perkara" => $perkara,
      "target_sidang" => $targetSidang,
      "jurusita" => $perkaraJurusita,
      "sidang_id_prev" => request("sidang_id_prev")
    ]);
  }

  public function tampil_alamat_pihak()
  {
    G_Input::mustHtmx();

    $pihak = Pihak::where('id', request('pihak_id'))->first();

    echo $this->load->component("panitera/alamat_pihak", [
      'alamat' => $pihak->alamat
    ]);
  }

  public function simpan($id = null)
  {
    G_Input::mustPost();

    $pihakData = explode('#', request('pihak_id'));

    try {
      if (count($pihakData) < 2) {
        throw new Exception("Kolom Pihak Masih Kosong", 1);
      }

      if (!$this->validation()) {
        throw new Exception(validation_errors(), 1);
      }

      $data = [
        'sidang_id' => request('sidang_id'),
        'jurusita_id' => request('jurusita_id'),
        'perkara_id' => request('perkara_id'),
        'pihak_id' => $pihakData[0],
        'jenis_panggilan' => request('jenis_panggilan'),
        'kode_panggilan' => request('kode_panggilan'),
        'jenis_pihak' => $pihakData[1],
        'tanggal_dibuat' => date('Y-m-d'),
        'untuk_tanggal' => request('tanggal_sidang'),
        'sidang_id_prev' => request('sidang_id_prev')
      ];

      if ($id) {
        $this->instrumenService->update($id, $data);
      } else {
        $this->instrumenService->simpan($data);
      }

      header("HX-Trigger: refetchTundaanSidang");

      echo $this->load->component('response_alert', [
        'message' => 'Instrumen Panggilan Sidang Lanjutan Berhasil Disimpan. Silahkan tutup jendela ini.'
      ]);
    } catch (\Throwable $th) {

      if ($th->getCode() == 409) {
        echo $this->load->component('response_alert', [
          'type' => 'danger',
          'message' => $th->getMessage() . "<br/>Silahkan Tutup Jendela Ini."
        ]);
      }
    }
  }

  public function daftar()
  {
    $perkaraDiterima = $this->perkaraService->perkaraDiterimaPanitera($this->userdata->panitera_id, null);
    $this->load
      ->js_plugin([
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::SWEETALERT2),
        base_url(LocalResource::VUE_PROD),
        base_url(LocalResource::DATATABLE_JS),
        base_url(LocalResource::MOMENT),
        base_url(LocalResource::HTMX),
      ])
      ->template("template", [
        "menus" => $this->get_user_menu(),
        "beranda_link" => $this->redirectPage[$this->userdata->name],
        "title" => "Panitera"
      ])
      ->page("daftar_instrumen_page", [
        "perkaraDiterima" => $perkaraDiterima,
      ]);
  }
}
