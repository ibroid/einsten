<?php

class Jurusita extends Illuminate\Database\Eloquent\Model
{
    protected $connection = 'sipp';
    protected $table = 'jurusita';

    public function instrumen()
    {
        return $this->hasMany(Instrumens::class);
    }
}
