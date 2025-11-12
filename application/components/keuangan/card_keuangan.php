<div class="col-6 col-lg-3 col-md-6">
  <div class="card">
    <div class="card-body px-4 py-4-5">
      <div class="row">
        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
          <div class="stats-icon purple mb-2">
            <i class="iconly-boldGraph"></i>
          </div>
        </div>
        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
          <h6 class="text-muted font-semibold">Jumlah Masuk Kantor</h6>
          <h6 class="font-extrabold mb-0"><?= $totalKantor ?></h6>
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
          <div class="stats-icon blue mb-2">
            <i class="iconly-boldProfile"></i>
          </div>
        </div>
        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
          <h6 class="text-muted font-semibold">Jumlah Jurnal</h6>
          <h6 class="font-extrabold mb-0"><?= rupiah($data->sum('jumlah')) ?></h6>
        </div>
      </div>
    </div>
  </div>
</div>