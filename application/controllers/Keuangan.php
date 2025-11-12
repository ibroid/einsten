<?php

class Keuangan extends G_Controller
{
  public JurusitaService $jurusitaService;
  public InstrumenService $instrumenService;
  public Eloquent $eloquent;
  public KeuanganService $keuanganService;
  public JurnalKeuanganService $jurnalService;

  public function __construct()
  {
    parent::__construct();

    if ($this->userdata->name !== "Kasir") {
      redirect('/', 'refresh');
    }

    $this->load->service("JurusitaService", null, 'jurusitaService');
    $this->load->service("InstrumenService", null, 'instrumenService');
    $this->load->service("KeuanganService", null, 'keuanganService');
    $this->load->service("JurnalKeuanganService", null, 'jurnalService');
  }

  public function index()
  {
    $this->load
      ->css_addon([
        PublicResource::FLATPICKR_CSS,
        base_url(LocalResource::DATATABLE_CSS)
      ])
      ->js_plugin([
        base_url(LocalResource::JQUERY),
        base_url(LocalResource::DATATABLE_JS),
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
      $potongan = $this->jurnalService->potonganBerlaku();

      $totalKantor = 0;
      $totalJurusita = 0;

      $mappedData = collect();
      // vardie($data);

      foreach ($data as $n => $d) {
        // echo json_encode($d);
        $pot =  $potongan
          ->filter(function ($v, $k) use ($d) {
            if ($v->filter_key) {
              return Illuminate\Support\Str::contains($v->keterangan, $v->filter_key);
            }
            return $d->jumlah == $v->jumlah_jurnal;
          })->first();

        $kantor = $pot->jumlah_kantor ?? 0;
        $jurusita = $pot->jumlah_jurusita ?? 0;

        $mappedData->push([
          "no" => ++$n,
          "tanggal_transaksi" => tanggal_indo($d->tanggal_transaksi),
          "nomor_perkara" => $d->nomor_perkara,
          "uraian" => $d->uraian . "<br/>" . $d->keterangan,
          "kode" => $d->kode,
          "jumlah_jurnal" => floatval(str_replace('.00', '',  $d->jumlah)),
          "jumlah_kantor" => floatval($kantor),
          "jumlah_jurusita" => floatval($jurusita),
        ]);

        $totalKantor += floatval($kantor);
        $totalJurusita += floatval($jurusita);
      }

      if ($this->input->request_headers('Hx-Request') == true) {
        header("Hx-Trigger-After-Swap: initDataTable");
        echo $this->load->component("keuangan/tampilkan_transaksi", [
          "data" => $mappedData,
          "total_kantor" => $totalKantor,
          "total_jurusita" => $totalJurusita
        ]);
      }
    } catch (\Throwable $th) {
      echo $th->getMessage();
      throw $th;
    }
  }
}
