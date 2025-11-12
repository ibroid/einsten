<?php
class PerkaraJurusita extends  Illuminate\Database\Eloquent\Model
{
    protected $connection = 'sipp';
    protected $table = 'perkara_jurusita';

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }
}
