<?php

class Instrumens extends Illuminate\Database\Eloquent\Model
{
    protected $connection = 'default';
    protected $table = 'instrumen';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($data) {
            $ci = &get_instance();
            $tglsidang = tanggal_indo($data->untuk_tanggal);

            $message = "*INSTRUMEN BARU*. Jenis Panggilan: $data->jenis_panggilan.\nNomor Perkara : " . $data->perkara->nomor_perkara . ".\nPihak : " . $data->pihak->nama . ".\nAlamat:" . $data->pihak->alamat . ".\nJenis Pihak : $data->jenis_pihak. Tanggal Sidang/Putus:$tglsidang";

            $ci->load->library('wanotif', [
                'number' => $data->jurusita->keterangan,
                'text' => $message
            ]);

            $ci->wanotif->send();
        });
    }

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id', 'perkara_id');
    }

    public function sidang_selanjutnya()
    {
        return $this->belongsTo(JadwalSidang::class, 'sidang_id', 'id');
    }

    public function sidang_sebelumnya()
    {
        return $this->belongsTo(JadwalSidang::class, 'sidang_id_prev', 'id');
    }

    public function pihak()
    {
        return $this->belongsTo(Pihak::class, 'pihak_id', 'id');
    }

    public function jurusita()
    {
        return $this->belongsTo(Jurusita::class, 'jurusita_id', 'id');
    }
}
