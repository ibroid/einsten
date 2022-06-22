<?php

require_once APPPATH . 'models/Perkara.php';

class PerkaraPanitera extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara_panitera_pn';

    public function perkara()
    {
        $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }
}
