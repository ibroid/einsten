<div class="alert alert-<?= $type ?? 'info' ?> text-center text-white" role="alert" id="root-notif">
  <?= "Instrumen dengan nomor perkara " . $data['nomor_perkara'] . " di tanggal sidang yang akan datang yaitu " . $data['tanggal_sidang'] . " atas nama pihak " . $data['nama_pihak'] . " dan jurusita " . $data['nama_jurusita'] . ", <strong class='text-danger'>Sudah ada</strong>. Apabila anda ingin mengupdate data dengan data baru silahkan pilih <strong>Update</strong>." ?>
  <form
    hx-post="<?= base_url('instrumen_sidang/simpan/' . $instrumen->id) ?>"
    hx-on::before-request="$('#update-button').text('Mohon Tunggu').attr('disabled', true)"
    hx-swap="replace"
    hx-target="#root-notif">
    <input type="hidden" name="sidang_id" value="<?= $data['sidang_id'] ?>">
    <input type="hidden" name="perkara_id" value="<?= $data['perkara_id'] ?>">
    <input type="hidden" name="jenis_panggilan" value="Panggilan Sidang Lanjutan">
    <input type="hidden" name="kode_panggilan" value="PSL">
    <input type="hidden" name="nama_pihak" value="<?= $data['nama_pihak'] ?>">
    <input type="hidden" name="nama_jurusita" value="<?= $data['nama_jurusita'] ?>">
    <input type="hidden" name="nomor_perkara" value="<?= $data['nomor_perkara'] ?>">
    <input type="hidden" name="pihak_id" value="<?= $data['pihak_id'] ?>">
    <input type="hidden" name="tanggal_sidang" value="<?= $data['tanggal_sidang'] ?>">
    <input type="hidden" name="sidang_id_prev" value="<?= $data['sidang_id_prev'] ?>">
    <input type="hidden" name="jurusita_id" value="<?= $data['jurusita_id'] ?>">
    <div class="flex text-center">
      <button id="update-button" class="btn btn-warning">Update</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
  </form>
</div>
</div>