<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Daftar Instrumen</h3>
  </div>
  <div class="page-content">
    <div class="card">
      <div class="card-body">
        <div class="container">
          <form
            hx-post="<?= base_url('keuangan/tampilkan') ?>"
            hx-target="#container"
            hx-on::before-request="$('#tampilkan-button').attr('disabled', true).text('Mohon Tunggu')"
            hx-on::after-request="$('#tampilkan-button').attr('disabled', false).text('Tampilkan')">
            <div class="mb-3 row">
              <label
                for="inputName"
                class="col-4 col-form-label text-end">Jangka Waktu</label>
              <div
                class="col-8">
                <input
                  required
                  type="text"
                  class="form-control date-range-picker"
                  name="jangka_waktu"
                  id="jangka_waktu"
                  placeholder="Tanggal" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="offset-sm-4 col-sm-8">
                <button id="tampilkan-button" type="submit" class="btn btn-primary">
                  <i class="bi bi-eye"></i>
                  Tampilkan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div id="container">

    </div>
  </div>
</div>


<script>
  window.addEventListener("load", () => {
    flatpickr(".date-range-picker", {
      mode: "range",
      dateFormat: "Y-m-d",
    })
  })
</script>