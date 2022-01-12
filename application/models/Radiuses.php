<?php
require_once FCPATH . 'vendor/autoload.php';

class Radiuses extends Illuminate\Database\Eloquent\Model
{
    protected $connection = 'local';
    protected $table = 'radius';
}
