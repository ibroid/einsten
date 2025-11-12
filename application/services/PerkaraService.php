<?php


class PerkaraService extends G_Service
{
  public function perkaraDiterimaPanitera($paniteraId, $tanggal)
  {
    return Perkara::select('nomor_perkara')
      ->whereHas("panitera", function ($qr) use ($paniteraId) {
        $qr->where('panitera_id', $paniteraId);
      })
      ->where('tanggal_pendaftaran', $tanggal ?? date('Y-m-d'))
      ->get();
  }
}
