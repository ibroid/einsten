<?php


class JurnalKeuanganService extends G_Service
{
  public function simpanPotonganBaru($data)
  {
    $total = $data['jumlah_kantor'] + $data['jumlah_jurusita'];

    if ($total != $data['jumlah_jurnal']) {
      throw new Exception("Akumulasi Jurnal Tidak Sesusai : " . ($data['jumlah_kantor'] + $data['jumlah_jurusita']));
    }

    return PotonganJurnal::create($data);
  }

  public function potonganBerlaku()
  {
    return PotonganJurnal::select('*')
      ->whereDate("berlaku_dari", "<=", date("Y-m-d"))
      ->whereDate("berlaku_sampai", ">=", date("Y-m-d"))
      ->get();
  }
}
