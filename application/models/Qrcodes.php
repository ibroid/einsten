<?php

class Qrcodes extends Illuminate\Database\Eloquent\Model
{
    protected $connection = 'local';
    protected $table = 'qrcode';
    protected $guarded = [];
}
