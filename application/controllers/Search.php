<?php

class Search extends G_Controller
{

    public function perkara()
    {
        if (isset($_POST)) {
            $nomor_perkara = request('nomor_perkara') . '/' . request('jenis_perkara') . '/' . request('tahun_perkara') . '/' . sysconf()->KodePN;

            $data = Perkara::with(['jadwal_sidang', 'pihak_satu', 'pihak_dua', 'jurusita', 'putusan'])->where('nomor_perkara', $nomor_perkara)->first();

            echo json_encode($data);
        }
    }
    public function jurusita($id = '')
    {
        if ($id) {
        } else {
            echo json_encode(Jurusita::with(['instrumen' => function ($qry) {
                $qry->whereDate('created_at', carbon()->now());
            }])->where('aktif', 'Y')->get());
        }
    }
    public function potongan()
    {
        $potongan = $this->capsule->connection('local')->table('potongan')->get();
        echo json_encode($potongan);
    }
}
