<?php


class JurusitaService extends G_Service
{
  public function perkaraJurusita($perkara_id)
  {
    return PerkaraJurusita::where('perkara_id', $perkara_id)->get();
  }

  public function allActive()
  {
    return Jurusita::where('aktif', 'Y')->get();
  }
}
