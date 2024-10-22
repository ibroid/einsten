<div class="content-wrapper container">
  <div class="page-heading">
    <h3>Daftar Radius Nasional</h3>
  </div>
  <div class="page-content">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="table-radius" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Satker</th>
                <th>Alamat</th>
                <th>Biaya</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var datatable;
  window.addEventListener("load", () => {
    datatable = $("#table-radius").DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url('radius_nasional/datatable') ?>",
        "type": "GET"
      },
      "columnDefs": [{
        "orderable": false,
        "target": [0]
      }]
    })
  })
</script>