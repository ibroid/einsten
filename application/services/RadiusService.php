<?php

class RadiusService extends G_Service
{
  public function datatable()
  {
    $draw = intval($this->input->get('draw'));
    $start = intval($this->input->get('start'));
    $length = intval($this->input->get('length'));
    $search = $this->input->get('search')['value'];

    $query = Radiuses::query();

    if (!empty($search)) {
      $query
        ->where('nama_satker', 'like', "%$search%")
        ->orWhere('kecamatan', 'like', "%$search%")
        ->orWhere('kelurahan', 'like', "%$search%")
        ->orWhere('kabupaten_kota', 'like', "%$search%")
        ->orWhere('nama_provinsi', 'like', "%$search%")
        ->orWhere('biaya', 'like', "%$search%")
      ;
    }

    $totalRecords = $query->count();

    $res = $query->skip($start)
      ->take($length)
      ->get();

    $data = [];
    $i = 1;

    foreach ($res as $d) {
      $data[] = [
        $i,
        $d->nama_satker,
        $d->kelurahan . "<br/>" . $d->kecamatan . "<br/>" . $d->kabupaten_kota . "<br/>" . $d->nama_provinsi,
        rupiah($d->biaya),
      ];
      $i++;
    }

    $output = [
      "draw" => $draw,
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $totalRecords,
      "data" => $data,
    ];

    echo json_encode($output);
  }
}
