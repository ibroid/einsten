<?php

class Perkara extends Illuminate\Database\Eloquent\Model
{
    protected $connection = "sipp";
    protected $table = 'perkara';
    protected $primaryKey  = 'perkara_id';

    public function jadwal_sidang()
    {
        return $this->hasMany(JadwalSidang::class, 'perkara_id', 'perkara_id')->orderBy('id', 'DESC');
    }
    public function pihak_satu()
    {
        return $this->hasMany(PihakSatu::class, 'perkara_id', 'perkara_id');
    }
    public function pihak_dua()
    {
        return $this->hasMany(PihakDua::class, 'perkara_id', 'perkara_id');
    }
    public function jurusita()
    {
        return $this->hasMany(PerkaraJurusita::class, 'perkara_id', 'perkara_id');
    }
    public function putusan()
    {
        return $this->hasOne(PerkaraPutusan::class, 'perkara_id', 'perkara_id');
    }
    public function panitera()
    {
        return $this->hasOne(PerkaraPanitera::class, 'perkara_id', 'perkara_id');
    }
    public function instrumen()
    {
        return $this->hasMany(Instrumens::class, 'perkara_id', 'perkara_id');
    }
}
