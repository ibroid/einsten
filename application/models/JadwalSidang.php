<?php

require_once APPPATH . 'models/Perkara.php';

class JadwalSidang extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara_jadwal_sidang';

    public function perkara()
    {
        $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }
}
