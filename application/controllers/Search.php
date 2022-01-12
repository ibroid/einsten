<?php

require_once APPPATH . 'models/Perkara.php';

class Search extends CI_Controller
{

    public function perkara()
    {
        if (isset($_POST)) {
            $nomor_perkara = request('nomor_perkara') . '/' . request('jenis_perkara') . '/' . request('tahun_perkara') . '/PA.JU';

            $data = Perkara::with(['jadwal_sidang', 'pihak_satu', 'pihak_dua', 'jurusita', 'putusan'])->where('nomor_perkara', $nomor_perkara)->first();

            echo json_encode($data);
        }
    }
}
