<?php
require_once APPPATH . 'models/Radiuses.php';
class Radius extends G_Controller
{
    public function index()
    {
        $data = Radiuses::all();
        echo json_encode($data);
    }

    public function update()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            show_404();
            exit;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://komdanas.mahkamahagung.go.id/jsons/radius04.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);

        echo 'start <br>';

        foreach ($data as $r) {
            try {
                Radiuses::updateOrCreate([
                    'kode_satker' => $r->satker_code,
                    'nama_provinsi' => $r->prop_name,
                    'kabupaten_kota' => $r->kabkota,
                    'kelurahan' => $r->kel,
                    'kecamatan' => $r->kec,
                    'kode_provinsi' => $r->prop,
                    'nama_satker' => $r->satker_name,
                ], [
                    'biaya' => $r->nilai,
                    'nomor_radius' => $r->nomor_radius,
                ]);
                echo 'sukses <br>';
            } catch (\Throwable $th) {
                echo $th->getMessage();
                echo '<br>';
            }
        }
    }
}
