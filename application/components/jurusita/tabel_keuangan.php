<div class="container">
  <div class="row my-2">
    <div class="col-4">
      <button type="button" class="btn btn-lg btn-success">
        <small>Total Belum Dicairkan</small><br>
        <h4 class="text-white">
          <?= rupiah($instrumen->sum('biaya')) ?? 0  ?>
        </h4>
      </button>
    </div>
    <div class="col-8">
      <div class="d-flex flex-row-reverse align-items-end">
        <?php if ($instrumen->sum('biaya')) { ?>
          <button
            hx-post="<?= base_url("instrumen/cairkan_semua") ?>"
            hx-vals='{"jurusita_id": "<?= $jurusita->id ?>"}'
            confirm-with-sweet-alert='true'
            hx-on::before-request="this.textContent = 'Mohon Tunggu'; this.disabled = true;"
            class="btn btn-sm btn-danger">
            <i class="bi bi-cash-stack"></i>
            Cairkan Semua
          </button>
        <?php }  ?>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-responsive table-hover table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Nomor Perkara</th>
          <th>Tanggal Sidang/Putus</th>
          <th>Jenis Panggilan</th>
          <th>Pihak</th>
          <th>Biaya</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($instrumen as $n => $in) { ?>
          <tr>
            <td><?= ++$n ?></td>
            <td>
              <?= $in->perkara->nomor_perkara ?>
              <details>
                Dibuat : <?= $in->created_at->diffForHumans() ?>
              </details>
            </td>
            <td><?= tanggal_indo($in->untuk_tanggal)  ?></td>
            <td><?= $in->jenis_panggilan ?></td>
            <td>
              <?= $in->pihak->nama ?>
              <details>
                <?= $in->pihak->alamat ?>
              </details>
            </td>
            <td>
              <?php if ($in->biaya) {
                echo rupiah($in->biaya);
              } else { ?>
                <form
                  hx-post="<?= base_url('instrumen/set_biaya') ?>"
                  hx-swap="afterbegin"
                  hx-on::before-request="this.textContent = 'Mohon Tunggu'">
                  <input type="hidden" name="id" value="<?= $in->id ?>">
                  <input name="biaya" required placeholder="Input Biaya Disini" type="number" class="form-control form-sm">
                  <button class="btn btn-sm btn-primary my-2">Simpan</button>
                </form>
              <?php } ?>
            </td>
            <td>
              <?php if (!$in->biaya) { ?>
                <p>Tidak bisa mencairkan yang belum mengisi biaya</p>
              <?php } else { ?>
                <button
                  type="button"
                  class="btn btn-danger btn-sm"
                  hx-post="<?= base_url("instrumen/cairkan") ?>"
                  hx-vals='{"id": "<?= $in->id ?>"}'
                  confirm-with-sweet-alert='true'
                  hx-swap="none">
                  <i class="bi bi-cash"></i>
                  Cairkan
                </button>
              <?php } ?>
            </td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>
  </div>
</div>