<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Daftar Instrumen</h3>
	</div>
	<div class="page-content">
		<div id="vue">
			<section>
				<div class="card">
					<div class="card-header">
						<h1 class="card-title">Ganti Username Untuk Login</h1>
					</div>
					<div class="card-body">
						<form action="<?= base_url('setelan/username') ?>" method="POST">
							<div class="form-group">
								<label for="">Username Lama</label>
								<input type="text" class="form-control" value="<?= $user->username ?>">
							</div>
							<div class="form-group">
								<label for="">Username Baru</label>
								<input type="text" name="username" class="form-control">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
						</form>
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