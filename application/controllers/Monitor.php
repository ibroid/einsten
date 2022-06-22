<?php


require_once APPPATH . 'models/JadwalSidang.php';
require_once APPPATH . 'models/Perkara.php';
require_once APPPATH . 'models/Users.php';

class Monitor extends CI_Controller
{
    public function harian()
    {
        template('template', 'app/monitor_harian', [
            'sidang' => JadwalSidang::where(function ($query) {
                $query->where('agenda', 'like', 'panggil%')->orWhere('agenda', 'SIDANG PERTAMA');
            })->whereDate('diinput_tanggal', date('Y-m-d'))->get()
        ]);
    }
    public function penggunaan()
    {
        template('template', 'app/monitor_penggunaan', [
            'user' => Users::where('level_id', 6)->get()
        ]);
    }
}
