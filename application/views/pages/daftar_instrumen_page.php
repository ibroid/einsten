<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Daftar Instrumen</h3>
  </div>
  <div class="page-content">
    <div id="vue">
      <section>
        <div class="card">
          <div class="card-header">
            <h1 class="card-title">Diurutkan berdasar yang terbaru</h1>
          </div>
          <div class="card-body">
            <div class="table-responsive">

              <table class="table table-hover table-bordered table-responsive" id="table-daftar-instrumen">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nomor Perkara</th>
                    <th rowspan="2">Jenis Panggilan</th>
                    <th rowspan="2">Nama Pihak</th>
                    <th rowspan="2">Jurusita</th>
                    <th colspan="4" class="text-center">Untuk Tanggal</th>
                    <th rowspan="2">Aksi</th>
                  </tr>
                  <tr>
                    <th>Tanggal Sidang</th>
                    <th>Tanggal Lanjutan</th>
                    <th>Tanggal Putus</th>
                    <th>Tanggal Ikrar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="9" class="text-center">Mohon Tunggu</td>
                  </tr>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
  var datatable;
  window.addEventListener("load", () => {
    datatable = $("#table-daftar-instrumen").DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('instrumen_sidang/tbody_daftar_instrumen') ?>",
        "type": "GET"
      },
      "columnDefs": [{
        "orderable": false,
        "target": [0]
      }]
    })
  })

  document.body.addEventListener('htmx:confirm', function(evt) {
    if (evt.target.matches("[confirm-with-sweet-alert='true']")) {
      evt.preventDefault();
      swal({
        title: "Are you sure?",
        text: "Are you sure you are sure?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((confirmed) => {
        if (confirmed) {
          evt.detail.issueRequest();
        }
      });
    }
  });


  function hapusInstrumen(id) {
    Swal.fire({
      title: 'Apa anda yakin ?',
      showCancelButton: true,
      confirmButtonText: 'Yakin',
      showLoaderOnConfirm: true,
      preConfirm: (login) => {
        //login is your inputed data
        const body = new FormData
        body.append('id', id)
        return fetch(`<?= base_url('instrumen/delete') ?>`, {
            method: "POST",
            body: body
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText)
            }
            return response.json()
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: error`
            )
          })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(result.value.message, "", "info").then(() => location.reload())
      }
    })
  }
</script>