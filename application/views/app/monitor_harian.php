<div class="content-wrapper container">
	<div class="page-heading">
		<h4>Penetapan Sidang Harian</h4>
	</div>
	<div class="page-container">
		<div id="vue">
			<section class="section">
				<div class="card">
					<div class="card-body">
						<h5>Total Penetapan Sidang Yang di Buat Hari Ini</h5>
						<table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Nomor Perkara</th>
									<th>Panitera Pengganti</th>
									<th>Tanggal Sidang</th>
									<th>Agenda Sidang</th>
									<th>Instrumen</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($sidang as $index => $sv) { ?>
									<tr>
										<td><?= ++$index ?></td>
										<td><?= $sv->perkara->nomor_perkara ?></td>
										<td><?= $sv->perkara->panitera->panitera_nama ?></td>
										<td><?= $sv->tanggal_sidang ?></td>
										<td><?= $sv->agenda ?></td>
										<td>
											<?php if ($sv->instrumen) { ?>
												<button class="btn btn-primary btn-sm">Instrumen Dibuat</button>
											<?php } else { ?>
												<button class="btn btn-danger btn-sm">Instrumen Belum Dibuat</button>
											<?php }  ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>

						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>