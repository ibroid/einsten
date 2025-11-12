<div class="col-12 col-lg-12">
  <div class="row">
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
              <div class="stats-icon yellow mb-2">
                <i class="iconly-boldWallet"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
              <h6 class="text-muted font-semibold">Total Transaksi</h6>
              <h6 class="font-extrabold mb-0"><?= $data->count() ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
              <div class="stats-icon purple mb-2">
                <i class="iconly-boldHome"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
              <h6 class="text-muted font-semibold">Jumlah Masuk Kantor</h6>
              <h6 class="font-extrabold mb-0"><?= rupiah($data->sum('jumlah_kantor')) ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
              <div class="stats-icon blue mb-2">
                <i class="iconly-boldProfile"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
              <h6 class="text-muted font-semibold">Jumlah Jurusita</h6>
              <h6 class="font-extrabold mb-0"><?= rupiah($data->sum('jumlah_jurusita')) ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
              <div class="stats-icon red mb-2">
                <i class="iconly-boldDocument"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
              <h6 class="text-muted font-semibold">Jumlah Jurnal</h6>
              <h6 class="font-extrabold mb-0"><?= rupiah($data->sum('jumlah_jurnal')) ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tabel-keuangan">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Tanggal Transaksi</th>
              <th class="text-center">Nomor Perkara</th>
              <th class="text-center">Uraian & Keterangan</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Nominal Jurnal</th>
              <th class="text-center">Nominal Kantor</th>
              <th class="text-center">Nominal Jurusita</th>
            </tr>
          </thead>
          <tbody>
            <?php $data->each(function ($d, $n) { ?>
              <tr>
                <td class="text-center"><?= $d['no'] ?></td>
                <td class="text-center"><?= $d['tanggal_transaksi']  ?></td>
                <td class="text-center"><?= $d['nomor_perkara'] ?></td>
                <td class="text-center"><?= $d['uraian'] ?></td>
                <td class="text-center"><?= $d['kode'] ?></td>
                <td class="text-center"><?= rupiah($d['jumlah_jurnal'])  ?></td>
                <td class="text-center"><?= rupiah($d['jumlah_kantor'])  ?></td>
                <td class="text-center"><?= rupiah($d['jumlah_jurusita'])  ?></td>
              </tr>
            <?php })  ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>