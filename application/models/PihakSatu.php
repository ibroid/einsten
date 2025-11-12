<?php
require_once APPPATH . 'models/Perkara.php';
class PihakSatu extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'perkara_pihak1';

    public function perkara()
    {
        return $this->belongsto(Perkara::class, 'perkara_id', 'perkara_id')->orderBy('id', 'DESC');
    }
}
