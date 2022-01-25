<?php

require_once FCPATH . 'vendor/autoload.php';
require_once APPPATH . 'models/Instrumens.php';
require_once APPPATH . 'models/Jurusita.php';
require_once APPPATH . 'models/Qrcodes.php';
include_once APPPATH . 'third_party/phpqrcode/qrlib.php';
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
        $js = Jurusita::find($data->jurusita_id);
        if ($js) {
            notifToJurusita([
                'number' => $js->keterangan,
                'text' => "*INSTRUMEN BARU*\n\n
                Jenis Panggilan: $data->jenis_panggilan\n\n
                Nomor Perkara : $data->nomor_perkara\n\n
                Pihak : $data->pihak\n\n
                Alamat: $data->alamat_pihak\n\n
                Jenis Pihak : $jenispihak\n\n
                Tanggal Sidang/Putus:$tglsidang"
            ]);
        }
    }

    public function today()
    {
        switch (auth()->user->level_id) {
            case '7':
                $data = Instrumens::whereDate('instrumen.created_at', carbon()->now())->where('jurusita_id', auth()->user->profile_id)->get();
                break;
            case '6':
                $data = Instrumens::select('instrumen.*', 'sipppaju.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipppaju.perkara_pelaksanaan_relaas', function ($join) {
                    $join->on('instrumen.sidang_id', '=', 'sipppaju.perkara_pelaksanaan_relaas.sidang_id');
                    $join->on('instrumen.pihak_id', '=', 'sipppaju.perkara_pelaksanaan_relaas.pihak_id');
                })->whereDate('instrumen.created_at', carbon()->now())->where('instrumen.created_by', auth()->user->id)->orderBy('instrumen.created_at', 'DESC')->get();
                break;
        }
        echo json_encode($data);
    }
    public function by_date()
    {
        $data = Instrumens::select('instrumen.*', 'sipppaju.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipppaju.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipppaju.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipppaju.perkara_pelaksanaan_relaas.pihak_id');
        })->whereDate('tanggal_sidang', request('date'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }
    public function delete()
    {
        $data = Instrumens::find(request('id'));
        $data->delete();
        echo json_encode(TRUE);
    }
    public function cetak($id = '')
    {
        $data = Instrumens::find($id);
        $sidang = $this->capsule->table('perkara_jadwal_sidang')->where('id', $data->sidang_id)->first();
        if ($data) {
            switch ($data->jenis_panggilan) {
                case 'Sidang Pertama':
                    $templatedocx = 'relaas/relaas_sidang_pertama_pihak' . $data->jenis_pihak . '.docx';
                    $filename = 'SIDANG_PERTAMA_' . $this->jenis_pihak_simp($data->jenis_pihak) . '_' . str_replace('/', '_', $data->nomor_perkara) . '.docx';
                    break;
                case 'Sidang Lanjutan':
                    $templatedocx = 'relaas/relaas_lanjutan.docx';
                    $filename = 'SIDANG_LANJUTAN_' . $this->jenis_pihak_simp($data->jenis_pihak) . '_' . str_replace('/', '_', $data->nomor_perkara) . '.docx';
                    break;
                default:

                    break;
            }

            $template = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . $templatedocx);
            $template->setValues(array_merge(
                $this->replace_data_pihak($data->pihak_id),
                $this->replace_perkara($data->perkara_id),
                $this->replace_jurusita($data->jurusita_id),
                [
                    'hari_tanggal_sidang' => carbon()->parse($data->tanggal_sidang)->isoFormat('dddd,D MMMM Y'),
                    'tanggal_sekarang' => carbon()->parse(date('Y-m-d'))->isoFormat('D MMMM Y'),
                    'hari_tanggal_sekarang' => carbon()->parse(date('Y-m-d'))->isoFormat('dddd,D MMMM Y'),
                    'ruang_sidang' => $this->ruang_sidang($sidang->ruangan),
                    'jenis_pihak' => $this->jenis_pihak_sort($data->nomor_perkara, $data->jenis_pihak),
                ]
            ));
            $pathToSave = FCPATH . 'hasil/' . $filename;
            $template->saveAs($pathToSave);
            redirect('hasil/' . $filename);
        } else {
            echo 'Data tidak ada';
        }
    }
    function ruang_sidang($ruang_id)
    {
        if ($ruang_id == 1) {
            return 'Umar Bin Khatab';
        } else if ($ruang_id == 2) {
            return 'Abu Musa';
        } else {
            return 'Asyuraih';
        }
    }
    public function replace_data_pihak($pihakid)
    {
        $pihak = $this->capsule->table('pihak')->where('id', $pihakid)->first();
        return [
            'nama_pihak' => $pihak->nama,
            'alamat_pihak' => $pihak->alamat,
            'tempat_tanggal_lahir' => "$pihak->tempat_lahir," . carbon()->parse($pihak->tanggal_lahir)->isoFormat('D MMMM Y'),
            'pekerjaan_pihak' => $pihak->pekerjaan,
            'pendidikan_pihak' => $pihak->pendidikan,
            'alamat_pihak' => $pihak->alamat,
        ];
    }
    function jenis_pihak_sort($par, $var)
    {
        if (strpos($par, 'Pdt.G') !== false) {
            if ($var == 1) {
                return 'Penggugat';
            }
            return 'Tergugat';
        } else {
            if ($var == 1) {
                return 'Pemohon';
            }
            return 'Termohon';
        }
    }
    public function replace_perkara($perkaraid)
    {
        $perkara = $this->capsule->table('perkara')->where('perkara.perkara_id', $perkaraid)->first();
        return [
            'nomor_perkara' => $perkara->nomor_perkara,
            'tanggal_instrumen' => carbon()->parse($perkara->tanggal_pendaftaran)->isoFormat('D MMMM Y'),
            'nama_penggugat' => $perkara->pihak1_text,
            'nama_tergugat' => $perkara->pihak2_text,
            'jenis_perkara' => $perkara->jenis_perkara_text
        ];
    }
    function jenis_pihak_simp($par)
    {
        if ($par == 1) {
            return 'P';
        }
        return 'T';
    }
    function replace_jurusita($jurusitaid)
    {
        $jurusita = $this->capsule->table('jurusita')->where('id', $jurusitaid)->first();
        return [
            'nama_jurusita' => $jurusita->nama_gelar,
            'jenis_jurusita' => $this->jenis_jurusita($jurusita->jabatan)
        ];
    }
    function jenis_jurusita($par)
    {
        if ($par == 1) {
            return 'Jurusita';
        }
        return 'Jurusita Pengganti';
    }
    public function search()
    {
        if (isset($_POST['tanggal_diterima'])) {
            $data = Instrumens::whereDate('created_at', request('tanggal_diterima'))->where('jurusita_id', auth()->user->profile_id)->orderBy('created_at', 'DESC')->get();
            echo json_encode($data);
        }
        if (isset($_POST['tanggal_sidang'])) {
            $data = Instrumens::whereDate('tanggal_sidang', request('tanggal_sidang'))->where('jurusita_id', auth()->user->profile_id)->orderBy('created_at', 'DESC')->get();
            echo json_encode($data);
        }
    }
    public function amplop($id)
    {
        $data = Instrumens::find($id);
        $perkara = $this->capsule->table('perkara')->where('perkara_id', $data->perkara_id)->first();
        $templatedocx =  new \PhpOffice\PhpWord\TemplateProcessor(FCPATH .  'relaas/template_amplop.docx');;
        $templatedocx->setValue('nomor_perkara', $data->nomor_perkara);
        $templatedocx->setValue('tanggal_sidang', carbon()->parse($perkara->tanggal_sidang)->isoFormat('D MMMM Y'));
        $templatedocx->setValue('jenis_perkara', $perkara->jenis_perkara_text);
        $templatedocx->setValue('nama_pihak', $data->pihak);
        $templatedocx->setValue('alamat_pihak', $data->alamat_pihak);
        $filename = 'AMPLOP_P' . $this->jenis_pihak_simp($data->jenis_pihak) . '_' . str_replace('/', '_', $data->nomor_perkara) . '.docx';
        $templatedocx->saveAs(FCPATH . 'hasil/' . $filename);
        redirect('hasil/' . $filename);
    }
    public function kwitansi($id)
    {
        $data = Instrumens::find($id);
        $perkara = $this->capsule->table('perkara')->where('perkara_id', $data->perkara_id)->first();
        $jurusita = $this->capsule->table('jurusita')->where('id', $data->jurusita_id)->first();
        $templatedocx =  new \PhpOffice\PhpWord\TemplateProcessor(FCPATH .  'relaas/template_kwitansi.docx');

        $templatedocx->setValue('nomor_perkara', $data->nomor_perkara);
        $templatedocx->setValue('tanggal_sidang', carbon()->parse($data->tanggal_sidang)->isoFormat('D MMMM Y'));
        $templatedocx->setValue('jenis_perkara', $perkara->jenis_perkara_text);
        $templatedocx->setValue('nama_pihak', $data->pihak);
        $templatedocx->setValue('nama_p', $perkara->pihak1_text);
        $templatedocx->setValue('nama_t', $perkara->pihak2_text);

        $qrcodedata = Qrcodes::create([
            'instrumen_id' => $data->id,
            'qrcode' => generateRandomString()
        ]);
        QRcode::png($qrcodedata->qrcode, FCPATH . 'hasil/qrcode.png');

        $templatedocx->setImageValue('barcode', FCPATH . 'hasil/qrcode.png');
        $templatedocx->setValue('jumlah_terbilang', terbilang($data->biaya));
        $templatedocx->setValue('untuk_biaya', $data->jenis_panggilan);
        $templatedocx->setValue('hari_tanggal_sekarang', carbon()->parse(date('Y-m-d'))->isoFormat('dddd, D MMMM Y'));
        $templatedocx->setValue('jenis_jurusita', $this->jenis_jurusita($jurusita->jabatan));
        $templatedocx->setValue('nama_jurusita', $jurusita->nama_gelar);
        $templatedocx->setValue('jenis_pihak', $this->jenis_pihak($data->jenis_pihak));

        $filename = 'KWITANSI_P' . $this->jenis_pihak_simp($data->jenis_pihak) . '_' . str_replace('/', '_', $data->nomor_perkara) . '.docx';
        $templatedocx->saveAs(FCPATH . 'hasil/' . $filename);
        redirect('hasil/' . $filename);
    }
}
