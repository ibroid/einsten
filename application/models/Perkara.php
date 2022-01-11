<?php
require_once FCPATH . 'vendor/autoload.php';
require_once APPPATH . 'models/JadwalSidang.php';
require_once APPPATH . 'models/PihakSatu.php';
require_once APPPATH . 'models/PihakDua.php';
require_once APPPATH . 'models/PerkaraJurusita.php';
require_once APPPATH . 'models/PerkaraPutusan.php';
class Perkara extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara';

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
}
