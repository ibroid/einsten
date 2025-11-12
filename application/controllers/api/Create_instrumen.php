<?php

use Illuminate\Support\Str;

class Create_instrumen extends API_Controller
{
  public InstrumenService $instrumenService;

  public function index()
  {
    try {
      $jsonPost = file_get_contents('php://input');

      $this->eloquent->capsule->connection('default')->beginTransaction();

      $this->eloquent->capsule->table('event_sipp')->insert([
        'event_name' => 'insert',
        'payload' =>  $jsonPost
      ]);

      $post = json_decode($jsonPost);

      $sidang = JadwalSidang::findOrFail($post->payload[0]);
      $perkara = $sidang->perkara;

      $jumlahJS = $perkara->jurusita->count();

      if ($jumlahJS > 2) {
        throw new Exception("Jumlah Jurusita Melebihi dua", 1);
      }

      if ($sidang->urutan == 1) {
        foreach ($perkara->jurusita as $js) {

          if ($js->urutan == 1) {
            $pihak = $perkara->pihak_satu;
            $jenisPihak = "P";
          } else {
            $pihak = $perkara->pihak_dua;
            $jenisPihak = "T";
          }

          Instrumens::create([
            "sidang_id" => $sidang->id,
            "panitera_id" => $perkara->panitera->id,
            "jurusita_id" => $js->jurusita_id,
            "perkara_id" => $perkara->perkara_id,
            "pihak_id" => $pihak[0]->pihak_id,
            "jenis_panggilan" => "Sidang Pertama",
            "kode_panggilan" => "SP",
            "jenis_pihak" => $jenisPihak,
            "untuk_tanggal" => $sidang->tanggal_sidang,
            "tanggal_dibuat" => date('Y-m-d')
          ]);
        }
      } else {
        if (!Str::contains($sidang->agenda, "instrumen")) {
          throw new Exception("Tidak ada kalimat instrumen di agenda sidang", 1);
        }

        if (
          Str::contains($sidang->agenda, "panggil penggugat") || Str::contains($sidang->agenda, "panggil pemohon")
        ) {
          $pihak = $perkara->pihak_satu;
          $jenisPihak = "P";
          $jurusita = $perkara->jurusita->where('urutan', 1)->first();
        }

        if (
          Str::contains($sidang->agenda, "panggil tergugat") ||
          Str::contains($sidang->agenda, "panggil termohon")
        ) {
          $pihak = $perkara->pihak_dua;
          $jenisPihak = "T";
          $jurusita = $perkara->jurusita->where('urutan', $jumlahJS)->first();
        }

        if (!$pihak || !$jurusita) {
          throw new Exception("Tidak ada pihak yang dipilih", 1);
        }

        Instrumens::create([
          "sidang_id" => $sidang->id,
          "panitera_id" => $perkara->panitera->id,
          "jurusita_id" => $jurusita->jurusita_id,
          "perkara_id" => $perkara->perkara_id,
          "pihak_id" => $pihak[0]->pihak_id,
          "jenis_panggilan" => "Sidang Lanjutan",
          "kode_panggilan" => "SL",
          "jenis_pihak" => $jenisPihak,
          "untuk_tanggal" => $sidang->tanggal_sidang,
          "tanggal_dibuat" => date('Y-m-d')
        ]);
      }
      $this->eloquent->capsule->connection('default')->commit();
      echo "Instrumen berhasil dikirim";
    } catch (\Throwable $th) {
      $this->eloquent->capsule->connection('default')->rollBack();
      echo $th->getMessage();
    }
  }
}
