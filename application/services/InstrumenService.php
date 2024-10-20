<?php

class InstrumenService extends G_Service
{
  public function simpan($data)
  {
    $cek = Instrumens::where([
      'sidang_id' => $data['sidang_id'],
      'pihak_id' => $data['pihak_id'],
    ])->first();

    if ($cek) {
      echo $this->load->component('panitera/konfirmasi_duplikat_instrumen', [
        'data' => request(),
        'instrumen' => $cek
      ]);
      exit;
    }

    return Instrumens::create($data + [
      'panitera_id' => auth()->panitera_id
    ]);
  }

  public function update($id, $data)
  {
    return Instrumens::find($id)->update($data + [
      'panitera_id' => auth()->panitera_id
    ]);
  }

  public function perkaraSidangDitunda($paniteraId)
  {
    return Perkara::query()
      ->select(
        'nomor_perkara',
        'tanggal_sidang',
        'alasan_ditunda',
        'dihadiri_oleh',
        'perkara.perkara_id',
        'para_pihak',
        'perkara_jadwal_sidang.id as sidang_id'
      )
      ->selectRaw("(select tanggal_sidang from perkara_jadwal_sidang where perkara_jadwal_sidang.perkara_id = perkara.perkara_id and date(tanggal_sidang) > curdate() limit 1) as ditunda_ke")
      ->leftJoin(
        "perkara_panitera_pn",
        "perkara.perkara_id",
        "perkara_panitera_pn.perkara_id"
      )
      ->leftJoin(
        "perkara_jadwal_sidang",
        "perkara.perkara_id",
        "perkara_jadwal_sidang.perkara_id"
      )
      ->whereDate(
        "perkara_jadwal_sidang.tanggal_sidang",
        date("Y-m-d")
      )
      ->where(
        "perkara_jadwal_sidang.ditunda",
        "Y"
      )
      ->where(
        "perkara_panitera_pn.panitera_id",
        $paniteraId
      )
      ->get();
  }

  public function today()
  {
    return Instrumens::where('panitera_id', auth()->panitera_id)->whereDate('tanggal_dibuat', date('Y-m-d'))->get();
  }

  public function paniteraDatatable()
  {
    $draw = intval($this->input->get('draw'));
    $start = intval($this->input->get('start'));
    $length = intval($this->input->get('length'));
    $search = $this->input->get('search')['value'];

    $dbSippName = $_ENV['DB_NAME_SIPP'];

    $query = Instrumens::query()
      ->select(
        "instrumen.*",
        "perkara.nomor_perkara",
        "jenis_panggilan",
        "jurusita.nama as nama_jurusita",
        "pihak.nama as nama_pihak",
        "untuk_tanggal"
      )
      ->leftJoin("$dbSippName.perkara", "perkara.perkara_id", "=", "instrumen.perkara_id")
      ->leftJoin("$dbSippName.jurusita", "jurusita.id", "=", "instrumen.jurusita_id")
      ->leftJoin("$dbSippName.pihak", "pihak.id", "=", "instrumen.pihak_id");
    if (!empty($search)) {
      $query
        ->where('jenis_panggilan', 'like', "%$search%")
        ->orWhere('nomor_perkara', 'like', "%$search%")
        ->orWhere('pihak.nama', 'like', "%$search%")
        ->orWhere('jurusita.nama', 'like', "%$search%")
      ;
    }

    $totalRecords = $query->count();

    $res = $query->skip($start)
      ->take($length)
      ->get();

    $data = [];
    $i = 1;

    foreach ($res as $d) {
      $data[] = [
        $i,
        $d->nomor_perkara,
        $d->jenis_panggilan,
        $d->nama_pihak,
        $d->nama_jurusita,
        $this->tanggalPemanggilan($d->jenis_panggilan, 'SP') ? tanggal_indo($d->untuk_tanggal) : null,
        $this->tanggalPemanggilan($d->jenis_panggilan, 'SL') ? tanggal_indo($d->untuk_tanggal) : null,
        $this->tanggalPemanggilan($d->jenis_panggilan, 'PIP') ? tanggal_indo($d->untuk_tanggal) : null,
        $this->tanggalPemanggilan($d->jenis_panggilan, 'SI') ? tanggal_indo($d->untuk_tanggal) : null,
        $this->load->component("panitera/button_aksi_daftar", [
          "data" => $d
        ])
      ];

      $i++;
    }

    $output = [
      "draw" => $draw,
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecords,
      "data" => $data,
    ];

    echo json_encode($output);
  }

  private function tanggalPemanggilan($par, $par2)
  {
    return $this->kode_panggilan($par) == $par2;
  }

  public function hapus($id)
  {
    $this->eloquent->capsule->connection('default')->transaction(function () use ($id) {
      $data = Instrumens::find($id);
      $trashData = $data->toArray();
      $data->delete();
      $trashData['tanggal_dihapus'] = date('Y-m-d');
      unset($trashData['tanggal_dibuat']);
      $this->eloquent->capsule->table('deleted_instrumen')->insertOrIgnore($trashData);
    });
  }

  public function kode_panggilan($par)
  {
    $data = [
      "Sidang Pertama" => "SP",
      "Sidang Lanjutan" => "SL",
      "Sidang Ikrar" => "SI",
      "Pemberitahuan Isi Putusan" => "PIP"
    ];

    return $data[$par];
  }
}
