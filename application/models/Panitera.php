<?php

require_once APPPATH . 'models/Perkara.php';
require_once APPPATH . 'models/Instrumens.php';
class Panitera extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'panitera_pn';

    public function instrumen()
    {
        return $this->hasMany(Instrumens::class);
    }
}
