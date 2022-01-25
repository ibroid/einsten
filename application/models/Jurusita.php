<?php

require_once APPPATH . 'models/Perkara.php';
require_once APPPATH . 'models/Instrumens.php';
class Jurusita extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'jurusita';

    public function instrumen()
    {
        return $this->hasMany(Instrumens::class);
    }
}
