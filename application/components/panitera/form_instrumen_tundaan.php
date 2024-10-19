<div class="container">
  <form
    autocomplete="off"
    hx-on::before-request="$('#button-save').text('Mohon Tunggu').attr('disabled', true)"
    hx-on::after-request="$('#button-save').html(`<i class='bi bi-save'></i> Simpan`).attr('disabled', false)"
    hx-post="<?= base_url('instrumen_sidang/simpan') ?>">
    <input type="hidden" name="sidang_id" value="<?= $target_sidang->id ?>">
    <input type="hidden" name="sidang_id_prev" value="<?= $sidang_id_prev ?>">
    <input type="hidden" name="perkara_id" value="<?= $perkara->perkara_id ?>">
    <input type="hidden" name="jenis_panggilan" value="Panggilan Sidang Lanjutan">
    <input type="hidden" name="kode_panggilan" value="PSL">
    <input type="hidden" name="nama_pihak" id="hidden_input_nama_pihak">
    <input type="hidden" name="nama_jurusita" id="hidden_input_nama_jurusita">
    <div class="mb-3 row">
      <label
        for="inputName"
        class="col-4 col-form-label">Nomor Perkara</label>
      <div
        class="col-8">
        <input
          type="text"
          class="form-control"
          name="nomor_perkara"
          value="<?= $perkara->nomor_perkara ?>"
          readonly />
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
          value="<?= $perkara->jenis_perkara_text ?>"
          disabled />
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
          <?php foreach ($perkara->pihak_satu as $ps) { ?>
            <option value="<?= $ps->pihak_id ?>#P"><?= $ps->nama ?> (Penggugat)</option>
          <?php } ?>
          <?php foreach ($perkara->pihak_dua as $pd) { ?>
            <option value="<?= $pd->pihak_id ?>#T"><?= $pd->nama ?> (Tergugat)</option>
          <?php } ?>
        </select>
        <div id="show_alamat_pihak"></div>
      </div>
    </div>
    <div class="mb-3 row">
      <label
        for="inputName"
        class="col-4 col-form-label">Tanggal Sidang Selanjutnya</label>
      <div
        class="col-8">
        <input
          type="text"
          class="form-control datepicker-swap"
          name="tanggal_sidang"
          value="<?= $target_sidang->tanggal_sidang ?>" />
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
          onchange="$('#hidden_input_nama_jurusita').val(this.options[this.selectedIndex].text)"
          class="form-select"
          name="jurusita_id">
          <option value="" selected disabled>--- Pilih Jurusita ---</option>
          <?php foreach ($jurusita as $js) { ?>
            <option value="<?= $js->jurusita_id ?>"><?= $js->jurusita_nama ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="mb-3 row">
      <div class="offset-sm-4 col-sm-8">
        <button id="button-save" type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i>
          Simpan
        </button>
      </div>
    </div>
  </form>
</div>