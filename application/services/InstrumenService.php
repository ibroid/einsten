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
      'panitera_id' => $this->session->userdata('g_user_loged')->panitera_id
    ]);
  }

  public function update($id, $data)
  {
    return Instrumens::find($id)->update($data + [
      'panitera_id' => $this->session->userdata('g_user_loged')->panitera_id
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
        // "2024-10-17"
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
    return Instrumens::where('panitera_id', $this->userdata->panitera_id)->whereDate('tanggal_dibuat', date('Y-m-d'))->get();
  }
}
