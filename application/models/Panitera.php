<?php

class PaniteraPN extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'panitera_pn';

    public function instrumen()
    {
        return $this->hasMany(Instrumens::class);
    }
}
