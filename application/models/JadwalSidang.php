<?php

class JadwalSidang extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara_jadwal_sidang';
    protected $connection = "sipp";

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }

    public function instrumen()
    {
        return $this->setConnection('local')->hasOne(Instrumens::class, 'sidang_id', 'id');
    }
}
