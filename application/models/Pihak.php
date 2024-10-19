<?php

use Illuminate\Database\Eloquent\Model;

class Pihak extends Model
{
  protected $connection = 'sipp';
  protected $table = 'pihak';
  protected $primaryKey = 'id';
}
