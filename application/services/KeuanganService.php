<?php

class KeuanganService extends G_Service
{
  public function tampikanTransaksi($awal, $akhir)
  {
    $this->load->library('Eloquent');

    return $this->eloquent->capsule->connection("sipp")->query()
      ->addSelect(
        'A.keterangan',
        'A.id',
        'A.tahapan_id',
        'A.perkara_id',
        'B.nomor_perkara',
        'A.tanggal_transaksi',
        'C.kode',
        'A.uraian',
        'A.jumlah',
        'A.jenis_transaksi'
      )
      ->from("perkara_biaya as A")
      ->leftJoin("perkara as B", "A.perkara_id", "=", "B.perkara_id")
      ->leftJoin("jenis_biaya as C", "A.jenis_biaya_id", "=", "C.id")
      ->whereDate("A.tanggal_transaksi", ">=", $awal)
      ->whereDate("A.tanggal_transaksi", "<=", $akhir)
      ->where(function ($qr) {
        $qr
          ->where('A.kategori_id', 6)
          ->orWhere('A.kategori_id', 4);
      })
      ->orderBy('A.tanggal_transaksi')
      ->get();
  }
}
