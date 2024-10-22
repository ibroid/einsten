<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Master Potongan</h3>
  </div>
  <div class="page-content">
    <div class="card">
      <div class="card-body">
        <div class="container">
          <div class="table-responsive">
            <div class="text-end">
              <button
                data-bs-toggle="modal"
                data-bs-target="#modalId"
                class="btn btn-success">
                <i class="bi bi-plus"></i>
                Tambah
              </button>
            </div>
            <table class="table table-hover table-bordered my-3">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Radius</th>
                  <th>Kata Kunci</th>
                  <th>Jumlah Jurnal</th>
                  <th>Jumlah Jurusita</th>
                  <th>Jumlah Kantor</th>
                  <th>Berlaku Dari</th>
                  <th>Berlaku Sampai</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $n => $d) { ?>
                  <tr>
                    <td><?= ++$n ?></td>
                    <td><?= $d->nama_radius ?></td>
                    <td><?= $d->filter_key ?></td>
                    <td><?= $d->jumlah_jurnal ?></td>
                    <td><?= $d->jumlah_jurusita ?></td>
                    <td><?= $d->jumlah_kantor ?></td>
                    <td><?= tanggal_indo($d->berlaku_dari)  ?></td>
                    <td><?= tanggal_indo($d->berlaku_sampai)  ?></td>
                    <td>
                      <div class="d-flex flex-row gap-2">
                        <button class="btn btn-sm btn-warning">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div
  class="modal fade"
  id="modalId"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"

  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true">
  <div
    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">
          Form Master Potongan
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form
            hx-post="<?= base_url("master_potongan/tambah") ?>"
            hx-target="#result-container"
            hx-on::before-request="$('#button-submit').attr('disabled', true).text('Mohon Tunggu')"
            hx-on::after-request="$('#button-submit').attr('disabled', false).html(`<i class='bi bi-save'></i>Simpan</button>`)">
            <div class=" mb-3 row">
              <label
                for="inputName"
                class="col-4 col-form-label">Nama Radius</label>
              <div
                class="col-8">
                <input
                  required
                  type="text"
                  class="form-control"
                  name="nama_radius"
                  id="inputName"
                  placeholder="RADIUS A, RADIUS B" />
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName2"
                class="col-4 col-form-label">Kata Kunci (Pembeda)</label>
              <div
                class="col-8">
                <input
                  type="text"
                  class="form-control"
                  name="filter_key"
                  id="inputName2"
                  placeholder="Contoh : PGK, KKP, (Bebas)" />
                <small class="text-danger"><i> *Digunakan ketika ada jumlah jurnal yang sama namun potongan berbeda. Kosongkan apabila tidak ada</i></small>
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName3"
                class="col-4 col-form-label">Jumlah Jurnal</label>
              <div
                class="col-8">
                <input
                  required
                  type="number"
                  class="form-control"
                  name="jumlah_jurnal"
                  id="inputName3"
                  placeholder="Contoh : 100000" />
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName4"
                class="col-4 col-form-label">Jumlah Kantor</label>
              <div
                class="col-8">
                <input
                  required
                  type="number"
                  class="form-control"
                  name="jumlah_kantor"
                  id="inputName4"
                  placeholder="Contoh : 45000" />
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName5"
                class="col-4 col-form-label">Jumlah Jurusita</label>
              <div
                class="col-8">
                <input
                  required
                  type="number"
                  class="form-control"
                  name="jumlah_jurusita"
                  id="inputName5"
                  placeholder="Contoh : 55000" />
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName6"
                class="col-4 col-form-label">Berlaku Dari</label>
              <div
                class="col-8">
                <input
                  required
                  type="text"
                  class="form-control datepicker"
                  name="berlaku_dari"
                  id="inputName6" />
              </div>
            </div>
            <div class="mb-3 row">
              <label
                for="inputName7"
                class="col-4 col-form-label">Berlaku Sampai</label>
              <div
                class="col-8">
                <input
                  required
                  type="text"
                  class="form-control datepicker"
                  name="berlaku_sampai"
                  id="inputName7" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="offset-sm-4 col-sm-8">
                <button id="button-submit" type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i>
                  Simpan
                </button>
              </div>
            </div>
          </form>
          <div id="result-container">

          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-dark"
          data-bs-dismiss="modal">
          <i class="bi bi-backspace"></i>
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener("load", () => {
    flatpickr(".datepicker")
  })
</script>