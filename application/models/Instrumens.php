<?php

require_once APPPATH . 'models/Jurusita.php';
class Instrumens extends Illuminate\Database\Eloquent\Model
{
    protected $connection = 'local';
    protected $table = 'instrumen';
    protected $guarded = [];
}
