<?php

require_once APPPATH . 'models/Perkara.php';
class PerkaraPutusan extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara_putusan';
    protected $guarded = [];

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }
}
