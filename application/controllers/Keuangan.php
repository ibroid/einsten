<?php

class Keuangan extends G_Controller
{
  public JurusitaService $jurusitaService;
  public InstrumenService $instrumenService;
  public Eloquent $eloquent;
  public KeuanganService $keuanganService;

  public function __construct()
  {
    parent::__construct();

    if ($this->userdata->name !== "Kasir") {
      redirect('/', 'refresh');
    }

    $this->load->service("JurusitaService", null, 'jurusitaService');
    $this->load->service("InstrumenService", null, 'instrumenService');
    $this->load->service("KeuanganService", null, 'keuanganService');
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
        "title" => "Keuangan"
      ])
      ->page("keuangan_page");
  }

  public function jurusita($id = null)
  {
    if ($id == null) {
      show_404();
    }
    if ($this->input->request_headers('Hx-Request') == true) {
      echo $this->load->component('jurusita/tabel_keuangan', [
        "instrumen" => $this->instrumenService->belumDicairkanJurusita($id),
        "jurusita" => Jurusita::find($id)
      ]);
    }
  }

  public function tampilkan()
  {
    try {
      $dateRange = explode(" to ", request('jangka_waktu'));
      if (count($dateRange) < 2) {
        echo "Kolom Tanggal Masih Kosong";
        return;
      }
      $awal = $dateRange[0];
      $akhir = $dateRange[1];

      $data = $this->keuanganService->tampikanTransaksi($awal, $akhir);

      if ($this->input->request_headers('Hx-Request') == true) {
        echo $this->load->component("keuangan/tampilkan_transaksi", [
          "data" => $data
        ]);
      }
    } catch (\Throwable $th) {
      //throw $th;
    }
  }
}
