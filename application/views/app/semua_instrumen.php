<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Daftar Instrumen</h3>
	</div>
	<div class="page-content">
		<div id="vue">
			<section>
				<div class="card">
					<div class="card-header">
						<h1 class="card-title">Semua Instrumen Yang Telah Dibuat</h1>
					</div>
					<div class="card-body">
						<div class="text-right">
							<a href="<?= base_url('app/daftar') ?>" class="btn btn-primary">Kembali</a>
						</div>
						<table id="myTable" class="table table-responsive table-hover table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Nomor Perkara</th>
									<th>Tanggal Sidang/Putus</th>
									<th>Jenis Panggilan</th>
									<th>Pihak</th>
									<th>Jurusita</th>
									<th>Relaas</th>
									<th>Aksi</th>
									<th>Dibuat</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data as $index => $ins) { ?>
									<tr>
										<td><?= ++$index ?></td>
										<td><?= $ins->nomor_perkara ?></td>
										<td><?= $ins->tanggal_sidang ?></td>
										<td><?= $ins->jenis_panggilan ?></td>
										<td><?= $ins->pihak ?></td>
										<td><?= $ins->jurusita_nama ?></td>
										<td>
											<a target="_blank" :href="'http://192.168.0.222/SIPP/'+ins.doc_relaas" v-if="ins.doc_relaas" class="btn btn-sm btn-warning">
												<i class="bi bi-file-earmark-font"></i>
											</a>
										</td>
										<td>
											<button v-on:click="hapusInstrumen(ins.id)" class="btn btn-sm btn-danger">
												<i class="bi bi-trash"></i>
											</button>
										</td>
										<td><?= $ins->created_at ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div ref="refModal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<table-filter @search_by_perkara="fetchByPerkara"></table-filter>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/vendors/simple-datatables/simple-datatables.js') ?>"></script>

<script>
	const dataTable = new simpleDatatables.DataTable("#myTable")
</script>