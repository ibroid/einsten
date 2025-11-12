<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Keuangan Instrumen</h3>
  </div>
  <div class="page-content">
    <div class="row">
      <?php
      foreach ((function ($pencairan_hari_ini) {
          return [
            [
              "title" => "Berhasil Dicairkan Hari Ini",
              "icon" => "iconly-boldGraph",
              "total" => $pencairan_hari_ini->count()
            ],
            [
              "title" => "Jurusita Mencairkan Hari Ini",
              "icon" => "iconly-boldUser",
              "total" => $pencairan_hari_ini->unique('jurusita_id')->count()
            ],
            [
              "title" => "Total Biaya Cair Hari Ini",
              "icon" => "iconly-boldWallet",
              "total" => rupiah($pencairan_hari_ini->sum('biaya'))
            ],
          ];
        })($pencairan_hari_ini) as $d
      ) { ?>
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body px-4 py-4-5">
              <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
                  <div class="stats-icon purple mb-2">
                    <i class="<?= $d['icon'] ?>"></i>
                  </div>
                </div>
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                  <h6 class="text-muted font-semibold"><?= $d['title'] ?></h6>
                  <h6 class="font-extrabold mb-0">
                    <?= $d['total'] ?>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

    </div>
    <div class="card">
      <div class="card-body">
        <div class="accordion" id="accordionExample">
          <?php foreach ($jurusita as $js) { ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?= $js->id ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $js->id ?>" aria-expanded="false" aria-controls="collapse<?= $js->id ?>">
                  <h6>
                    <?= $js->nama ?>
                    <?php $blmCair = $js->instrumen()->where('pencairan', 0)->count();
                    if ($blmCair) { ?>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $blmCair ?>
                        <span class="visually-hidden">Belum Dicairkan</span>
                      </span>
                    <?php }
                    ?>


                  </h6>
                </button>
              </h2>
              <div id="collapse<?= $js->id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $js->id ?>" data-bs-parent="#accordionExample">
                <div
                  class="accordion-body"
                  hx-get="<?= base_url('keuangan/jurusita/' . $js->id) ?>"
                  hx-trigger="intersect, fetchTabelKeuanganJurusita">
                  <div class="text-center">
                    <h5>Mohon Tunggu ...</h5>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.body.addEventListener('htmx:confirm', function(evt) {
    if (evt.target.matches("[confirm-with-sweet-alert='true']")) {
      evt.preventDefault();
      Swal.fire({
        title: "Apa anda yakin ?",
        text: "Pastikan kegiatan pencairan berlangsung bersama jurusita terkait",
        icon: "warning",
        showCancelButton: true,
      }).then((confirmed) => {
        if (confirmed) {
          evt.detail.issueRequest();
        }
      });
    }
  });
</script>