<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Daftar Pencairan</h3>
  </div>
  <div class="page-content">
    <div id="vue">
      <section>
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Diurutkan berdasar yang terbaru</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-responsive" id="table-daftar-pencairan">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Perkara</th>
                    <th>Jenis Panggilan</th>
                    <th>Nama Pihak</th>
                    <th>Jurusita</th>
                    <th class="text-center">Sidang/Putus/Ikrar</th>
                    <th>Biaya</th>
                    <th>Tanggal Pencairan</th>
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
    datatable = $("#table-daftar-pencairan").DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('pencairan/datatable') ?>",
        "type": "GET"
      },
      "columnDefs": [{
        "orderable": false,
        "target": [0]
      }]
    })
  })
</script>