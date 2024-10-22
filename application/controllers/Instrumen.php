<?php

class Instrumen extends G_Controller
{
    public InstrumenService $instrumenService;

    function __construct()
    {
        parent::__construct();
        $this->load->service('InstrumenService', null, 'instrumenService');
        $this->load->library('Eloquent');
    }

    public function index()
    {
        $data = Instrumens::firstOrCreate([
            'sidang_id' => request('sidang_id'),
            'pihak_id' => request('pihak_id'),
        ], [
            'jurusita_id' => request('jurusita_id'),
            'biaya' => request('biaya'),
            'perkara_id' => request('perkara_id'),
            'jenis_pihak' => request('jenis_pihak') == 1 ? 'P' : 'T',
            'jenis_panggilan' => request('jenis_panggilan'),
            'tanggal_dibuat' => date("Y-m-d"),
            'panitera_id' => auth()->panitera_id,
            'untuk_tanggal' => request("tanggal_sidang"),
            'kode_panggilan' => $this->instrumenService->kode_panggilan(request('jenis_panggilan'))
        ]);

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
            $message = "*INSTRUMEN BARU*. Jenis Panggilan: $data->jenis_panggilan. Nomor Perkara : $data->nomor_perkara. Pihak : $data->pihak. Alamat: $data->alamat_pihak.Jenis Pihak : $jenispihak. Tanggal Sidang/Putus:$tglsidang";
        } else {
            $message = "*INSTRUMEN DELEGASI BARU*. Jenis Panggilan: $data->jenis_panggilan. Nomor Perkara : $data->nomor_perkara. Pihak : $data->pihak. Alamat: $data->alamat_pihak. Jenis Pihak : $jenispihak. Tanggal Sidang/Putus:$tglsidang";
        }
        $this->load->library('wanotif', [
            'number' => $js->keterangan,
            'text' => $message
        ]);
        $this->wanotif->send();
    }

    public function today()
    {
        if (auth()->panitera_id !== null) {
            $data = Instrumens::with("perkara")->with("jurusita")->with("pihak")
                ->whereDate('instrumen.tanggal_dibuat', date('Y-m-d'))
                ->where('instrumen.panitera_id', auth()->panitera_id)
                ->orderBy('instrumen.created_at', 'DESC')
                ->get();

            header("Content-Type: application/json");
            echo json_encode($data);
            exit;
        }

        if (auth()->jurusita_id !== null) {
            $data = Instrumens::with('perkara:perkara_id,nomor_perkara,jenis_perkara_nama')
                ->with('pihak')
                ->whereDate('instrumen.tanggal_dibuat', carbon()->now())
                ->where('jurusita_id', auth()->jurusita_id)->get();

            header("Content-Type: application/json");
            echo json_encode($data);
            exit;
        }
    }
    public function by_date()
    {
        $data = Instrumens::select('instrumen.*', 'sipp.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipp.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipp.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipp.perkara_pelaksanaan_relaas.pihak_id');
        })->whereDate('tanggal_sidang', request('date'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }
    public function delete()
    {
        try {
            $this->instrumenService->hapus(request('id'));

            echo json_encode([
                'message' => "Berhasil dihapus"
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'message' => 'Terjadi Kesalahan. ' . $th->getMessage()
            ]);
        }
    }
    public function cetak($id = '')
    {
        $data = Instrumens::find($id);
        $sidang = $this->eloquent->capsule->connection('sipp')->table('perkara_jadwal_sidang')->where('id', $data->sidang_id)->first();
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
        $pihak = $this->eloquent->capsule->connection('sipp')->table('pihak')->where('id', $pihakid)->first();
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
        $perkara = $this->eloquent->capsule->connection('sipp')->table('perkara')->where('perkara.perkara_id', $perkaraid)->first();
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
        $jurusita = $this->eloquent->capsule->connection('sipp')->table('jurusita')->where('id', $jurusitaid)->first();
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
            $data = Instrumens::with('perkara:perkara_id,nomor_perkara,jenis_perkara_nama')
                ->with('pihak')->whereDate('tanggal_dibuat', request('tanggal_diterima'))->where('jurusita_id', auth()->jurusita_id)->orderBy('created_at', 'DESC')->get();
            echo json_encode($data);
        }

        if (isset($_POST['tanggal_sidang'])) {
            $data = Instrumens::with('perkara:perkara_id,nomor_perkara,jenis_perkara_nama')
                ->with('pihak')->whereDate('untuk_tanggal', request('tanggal_sidang'))->where('jurusita_id', auth()->jurusita_id)->orderBy('created_at', 'DESC')->get();
            echo json_encode($data);
        }

        if (isset($_POST['nomor_perkara'])) {
            $data = Instrumens::with(['perkara:perkara_id,nomor_perkara,jenis_perkara_nama' => function ($q) {
                $q->where('nomor_perkara', request('nomor_perkara'));
            }])
                ->with('pihak')->whereDate('untuk_tanggal', request('tanggal_sidang'))->where('jurusita_id', auth()->jurusita_id)->orderBy('created_at', 'DESC')->get();
            echo json_encode($data);
        }
    }
    public function amplop($id)
    {
        $data = Instrumens::find($id);
        $perkara = $this->eloquent->capsule->connection('sipp')->table('perkara')->where('perkara_id', $data->perkara_id)->first();
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
        $perkara = $this->eloquent->capsule->connection('sipp')->table('perkara')->where('perkara_id', $data->perkara_id)->first();
        $jurusita = $this->eloquent->capsule->connection('sipp')->table('jurusita')->where('id', $data->jurusita_id)->first();
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

    public function by_perkara()
    {
        $data = Instrumens::select('instrumen.*', 'sipp.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipp.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipp.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipp.perkara_pelaksanaan_relaas.pihak_id');
        })->where('instrumen.nomor_perkara', request('nomor_perkara'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }

    public function by_jurusita()
    {
        $data = Instrumens::select('instrumen.*', 'sipp.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipp.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipp.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipp.perkara_pelaksanaan_relaas.pihak_id');
        })->where('instrumen.jurusita_id', request('jurusita_id'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }

    public function by_created()
    {
        $data = Instrumens::select('instrumen.*', 'sipp.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipp.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipp.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipp.perkara_pelaksanaan_relaas.pihak_id');
        })->whereDate('instrumen.created_at', request('tanggal_dibuat'))->where('created_by', auth()->user->id)->get();
        echo json_encode($data);
    }

    public function semua()
    {
        $data = Instrumens::select('instrumen.*', 'sipp.perkara_pelaksanaan_relaas.doc_relaas')->leftJoin('sipp.perkara_pelaksanaan_relaas', function ($join) {
            $join->on('instrumen.sidang_id', '=', 'sipp.perkara_pelaksanaan_relaas.sidang_id');
            $join->on('instrumen.pihak_id', '=', 'sipp.perkara_pelaksanaan_relaas.pihak_id');
        })->where('created_by', auth()->user->id)->get();
        template('template', 'app/semua_instrumen', [
            'data' => $data
        ]);
    }

    public function set_biaya()
    {
        G_Input::mustPost();
        try {
            Instrumens::where('id', request('id'))->update([
                'biaya' => request('biaya')
            ]);

            if ($this->input->request_headers('Hx-Request') == true) {
                header("HX-Trigger: fetchTabelKeuanganJurusita");
            } else {
                echo json_encode(['message' => "Set Biaya ok"]);
            }
        } catch (\Throwable $th) {
            if ($this->input->request_headers('Hx-Request') == true) {
                echo "Terjadi kesalahan : " . $th->getMessage();
            } else {
                set_status_header(400);
                echo json_encode(['message' => $th->getMessage()]);
            }
        }
    }

    public function cairkan()
    {
        G_Input::mustPost();
        try {
            $this->instrumenService->update(request('id'), [
                'pencairan' => 1,
                'tanggal_pencairan' => date('Y-m-d')
            ]);
            if ($this->input->request_headers('Hx-Request') == true) {
                header("HX-Trigger: fetchTabelKeuanganJurusita");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cairkan_semua()
    {
        G_Input::mustPost();
        try {
            Instrumens::where([
                'pencairan' => 0,
                'jurusita_id' => request('jurusita_id')
            ])->update([
                'pencairan' => 1,
                'tanggal_pencairan' => date('Y-m-d')
            ]);

            if ($this->input->request_headers('Hx-Request') == true) {
                header("HX-Trigger: fetchTabelKeuanganJurusita");
            }
        } catch (\Throwable $th) {
            if ($this->input->request_headers('Hx-Request') == true) {
                echo "Terjadi Kesalahan. Error : " . $th->getMessage();
                exit;
            }
            throw $th;
        }
    }
}
