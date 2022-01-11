<?php
require_once APPPATH . 'models/Radiuses.php';
class Radius extends CI_Controller
{
    public function index()
    {
        $data = Radiuses::all();
        echo json_encode($data);
    }
    public function update()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://192.168.0.212/resources/api/radius/400622");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);
        echo '<pre>';
        foreach ($data as $r) {
            try {
                Radiuses::upsert([
                    'nama_satker' => $r->nama_satker,
                    'kode_satker' => $r->kode_satker,
                    'kode_provinsi' => $r->kode_provinsi,
                    'nama_provinsi' => $r->nama_provinsi,
                    'kabupaten_kota' => $r->kabupaten_kota,
                    'kecamatan' => $r->kecamatan,
                    'kelurahan' => $r->kelurahan,
                    'nomor_radius' => $r->nomor_radius,
                    'biaya' => $r->biaya,
                ], ['kode_satker'], ['biaya']);
                echo 'sukses <br>';
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
