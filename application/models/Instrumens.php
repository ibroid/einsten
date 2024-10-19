<?php

class Instrumens extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'instrumen';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }

    public function sidang_selanjutnya()
    {
        return $this->belongsTo(JadwalSidang::class, 'sidang_id', 'id');
    }

    public function sidang_sebelumnya()
    {
        return $this->belongsTo(JadwalSidang::class, 'sidang_id_prev', 'id');
    }

    public function pihak()
    {
        return $this->belongsTo(Pihak::class, 'pihak_id', 'id');
    }

    public function jurusita()
    {
        return $this->belongsTo(Jurusita::class, 'jurusita_id', 'id');
    }
}
