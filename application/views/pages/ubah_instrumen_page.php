<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Ubah Instrumen</h3>
  </div>
  <div class="page-content">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="container">
            <form
              autocomplete="off"
              hx-on::before-request="$('#button-save').text('Mohon Tunggu').attr('disabled', true)"
              hx-on::after-request="$('#button-save').html(`<i class='bi bi-save'></i> Simpan`).attr('disabled', false)"
              hx-post="<?= base_url('instrumen_sidang/ubah/' . $instrumen->id) ?>">
              <input type="hidden" name="perkara_id" value="<?= $instrumen->perkara_id ?>">
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Nomor Perkara</label>
                <div
                  class="col-8">
                  <input
                    type="text"
                    class="form-control"
                    value="<?= $instrumen->perkara->nomor_perkara ?>"
                    disabled />
                </div>
              </div>
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Jenis Perkara</label>
                <div
                  class="col-8">
                  <input
                    type="text"
                    class="form-control"
                    value="<?= $instrumen->perkara->jenis_perkara_text ?>"
                    disabled />
                </div>
              </div>
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Jenis Panggilan</label>
                <div
                  class="col-8">
                  <select
                    class="form-select"
                    name="jenis_panggilan"
                    id="select_jenis_panggilan">
                    <?php foreach ((function () {
                        return [
                          "Pemberitahuan Isi Putusan",
                          "Sidang Ikrar",
                          "Sidang Lanjutan",
                          "Sidang Pertama",
                        ];
                      })() as $op
                    ) { ?>
                      <option <?= $op == $instrumen->jenis_panggilan ? "selected" : false ?>><?= $op ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Tanggal (Sidang/Putus/Ikrar)</label>
                <div
                  class="col-8">
                  <input value="<?= $instrumen->untuk_tanggal ?>" type="text" name="untuk_tanggal" class="form-control datepicker">
                </div>
              </div>
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Pihak yang akan dipanggil</label>
                <div
                  class="col-8">
                  <select
                    id="select-pihak"
                    hx-post="<?= base_url('instrumen_sidang/tampil_alamat_pihak') ?>"
                    hx-trigger="change"
                    hx-target="#show_alamat_pihak"
                    hx-on::after-request="$('#hidden_input_nama_pihak').val(this.options[this.selectedIndex].text)"
                    required
                    class="form-select"
                    name="pihak_id">
                    <option value="" selected disabled>--- Pilih Pihak ---</option>
                    <?php foreach ($instrumen->perkara->pihak_satu as $ps) { ?>
                      <option
                        <?= ($instrumen->pihak_id == $ps->pihak_id) ? 'selected' : false ?>
                        value="<?= $ps->pihak_id ?>#P"><?= $ps->nama ?> (Penggugat)</option>
                    <?php } ?>
                    <?php foreach ($instrumen->perkara->pihak_dua as $pd) { ?>
                      <option <?= ($instrumen->pihak_id == $pd->pihak_id) ? 'selected' : false ?> value="<?= $pd->pihak_id ?>#T"><?= $pd->nama ?> (Tergugat)</option>
                    <?php } ?>
                  </select>
                  <div id="show_alamat_pihak"></div>
                </div>
              </div>
              <div class="mb-3 row">
                <label
                  for="inputName"
                  class="col-4 col-form-label">Jurusita</label>
                <div
                  class="col-8">
                  <select
                    required
                    class="form-select"
                    name="jurusita_id">
                    <?php foreach ($jurusita as $js) { ?>
                      <option <?= ($js->jurusita_id == $instrumen->jurusita_id) ? 'selected' : false ?> value="<?= $js->jurusita_id ?>"><?= $js->jurusita_nama ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                  <a href="<?= base_url('instrumen_sidang/daftar') ?>" type="button" class="btn btn-danger">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                  </a>
                  <button id="button-save" type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener("load", () => {
    flatpickr(".datepicker")
  })
</script>