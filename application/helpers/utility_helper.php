<?php

if (!function_exists("vardie")) {
  function vardie(...$data)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
  }
}

if (!function_exists("tanggal_indo")) {
  function tanggal_indo($date = null)
  {
    if ($date == null) {
      return null;
    }

    $bulan = array(
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

    $pecahkan = explode('-', $date);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
  }
}


if (!function_exists("dihadiri_oleh")) {
  function dihadiri_oleh($p)
  {
    $kehadiran = [
      1 => "Semua Pihak",
      2 => "Penggugat Saja",
      3 => "Tergugat Saja",
      10 => "Sebagian Penggugat",
      11 => "Sebagian Tergugat",
      4 => "Para Pihak Tidak Hadir (Gak niat sidang kek nya, haduh)",
    ];

    return $kehadiran[$p] ?? "Tidak Diketahui";
  }
}


if (!function_exists('rupiah')) {
  function rupiah($nominal = null)
  {
    $hasil = number_format($nominal, 0, ",", ".");
    return "Rp. $hasil";
  }
}
