<?php

require_once APPPATH . 'models/Instrumens.php';
require_once APPPATH . 'models/Jurusita.php';
class Instrumen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Instrumens::firstOrCreate([
            'sidang_id' => request('sidang_id'),
            'pihak' => request('pihak')
        ], [
            'jurusita_id' => request('jurusita_id'),
            'jurusita_nama' => request('jurusita_nama'),
            'tanggal_sidang' => request('tanggal_sidang'),
            'nomor_perkara' => request('nomor_perkara'),
            'alamat_pihak' => request('alamat_pihak'),
            'agenda' => request('agenda'),
            'biaya' => request('biaya'),
            'perkara_id' => request('perkara_id'),
            'pihak_id' => request('pihak_id'),
            'jenis_pihak' => request('jenis_pihak'),
            'jenis_panggilan' => request('jenis_panggilan'),
            'created_by' => auth()->user->id
        ]);
        $this->notifJs($data);
        echo json_encode($data);
    }
    function jenis_pihak($par)
    {
        if ($par == 1) {
            return 'Penggugat/Pemohon';
        }
        return 'Terggugat/Termohon';
    }

    public function notifJs($data)
    {
        $tglsidang = carbon()->parse($data->tanggal_sidang)->isoFormat('dddd, D MMMM Y');
        $jenispihak = $this->jenis_pihak($data->jenis_pihak);
        $data = Jurusita::find($data->jurusita_id);
        notifToJurusita([
            'number' => $data->keterangan,
            'text' => "*INSTRUMEN PANGGILAN BARU*
            \n$data->nomor_perkara\n$data->pihak\n$data->alamat_pihak\n$jenispihak\n$data->alamat_pihak\nTanggal Sidang:$tglsidang"
        ]);
    }

    public function today()
    {
        switch (auth()->user->level_id) {
            case '7':
                $data = Instrumens::whereDate('instrumen.created_at', carbon()->now())->where('jurusita_id', auth()->user->profile_id)->get();
                break;
            case '6':
                $data = Instrumens::select('instrumen.*', 'sipppaju_backup.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipppaju_backup.perkara_pelaksanaan_relaas', function ($join) {
                    $join->on('instrumen.sidang_id', '=', 'sipppaju_backup.perkara_pelaksanaan_relaas.sidang_id');
                    $join->on('instrumen.pihak_id', '=', 'sipppaju_backup.perkara_pelaksanaan_relaas.pihak_id');
                })->whereDate('instrumen.created_at', carbon()->now())->where('instrumen.created_by', auth()->user->id)->orderBy('instrumen.created_at', 'DESC')->get();
                break;
        }
        echo json_encode($data);
    }
    public function by_date()
    {
        $data = Instrumens::select('instrumen.*', 'sipppaju_backup.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipppaju_backup.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipppaju_backup.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipppaju_backup.perkara_pelaksanaan_relaas.pihak_id');
        })->whereDate('tanggal_sidang', request('date'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }
    public function delete()
    {
        $data = Instrumens::find(request('id'));
        $data->delete();
        echo json_encode(TRUE);
    }
    public function cetak($id)
    {
        $data = Instrumens::find($id);
        if ($data) {
            switch ($data->jenis_panggilan) {
                case 'Sidang Pertama':
                    $template = 'relaas_sidang_pertama_pihak' . $data->jenis_pihak . '.docx';
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            echo 'Data tidak ada';
        }
        $data_pihak = $this->replace_data_pihak($data->pihak_id);
    }
    public function replace_data_pihak($data)
    {
        return [
            'nama_pihak' => $data
        ];
    }
}
