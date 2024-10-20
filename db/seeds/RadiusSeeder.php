<?php


use Phinx\Seed\AbstractSeed;

class RadiusSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(600);
        $dataJson = file_get_contents('./radius.json');
        $dataArr = json_decode($dataJson);
        $radius = $this->table('radius');
        foreach ($dataArr as $r) {
            $radius->insert([
                'kode_satker' => $r->satker_code,
                'nama_provinsi' => $r->prop_name,
                'kabupaten_kota' => $r->kabkota,
                'kelurahan' => $r->kel,
                'kecamatan' => $r->kec,
                'kode_provinsi' => $r->prop,
                'nama_satker' => $r->satker_name,
                'biaya' => $r->nilai,
                'nomor_radius' => $r->nomor_radius,
            ])->saveData();
        }
    }
}
