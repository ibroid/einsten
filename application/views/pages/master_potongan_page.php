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
                    <th><?= ++$n ?></th>
                    <th><?= $d->nama_radius ?></th>
                    <th><?= $d->filter_key ?></th>
                    <th><?= $d->jumlah_jurnal ?></th>
                    <th><?= $d->jumlah_jurusita ?></th>
                    <th><?= $d->jumlah_kantor ?></th>
                    <th><?= $d->berlaku_dari ?></th>
                    <th><?= $d->berlaku_sampai ?></th>
                    <th>
                      <div class="d-flex flex-row">
                        <button class="btn btn-sm btn-warnig">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </th>
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
          <form>
            <div class="mb-3 row">
              <label
                for="inputName"
                class="col-4 col-form-label">Nama Radius</label>
              <div
                class="col-8">
                <input
                  type="text"
                  class="form-control"
                  name="nama_radius"
                  id="inputName"
                  placeholder="Name" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="offset-sm-4 col-sm-8">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i>
                  Simpan
                </button>
              </div>
            </div>
          </form>
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