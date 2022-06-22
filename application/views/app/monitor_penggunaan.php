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
									<th>Nama Panitera</th>
									<th>Jumlah Instrumen Yang Dibuat</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($user as $index => $sv) { ?>
									<tr>
										<td><?= ++$index ?></td>
										<td><?= $sv->profile->nama ?></td>
										<td><?= $sv->instrumen->count() ?></td>
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