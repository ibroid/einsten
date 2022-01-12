<div class="content-wrapper container">
	<div class="page-heading">
		<h4>Instrumen</h4>
	</div>
	<div class="page-content">
		<div id="vue">
			<section>
				<div class="card blue-grey darken-1">
					<div class="card-body">
						<h4 class="card-title">Instrumen Hari Ini</h4>
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-sm btn-primary">
									<i class="bi bi-calendar"></i>
									Daftar Hari Ini
								</button>
								<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-sm btn-success">
									<i class="bi bi-filter-square"></i>
									Kategori Instrumen
								</button>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-sm-6">
										<input type="date" class="form-control">
									</div>
									<div class="col-sm-6">
										<button class="btn btn-sm btn-danger">
											<i class="bi bi-filter-square"></i>
											Cari Berdasarkan Tanggal Sidang
										</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<table-instrumen :instrumen="dataApi.instrumen"></table-instrumen>
					</div>
				</div>
				<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<table></table>
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
<script src="<?= base_url('assets/js/vue/dist/vue.global.js') ?>"></script>
<script src="<?= base_url('assets/js/moment/moment.js') ?>"></script>
<script>
	const showLoading = () => {
		return Swal.fire({
			text: "Mohon Tunggu",
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading()
			},
			allowOutsideClick: () => !Swal.isLoading(),
			backdrop: true
		})
	}

	const {
		createApp,
		reactive,
		onMounted
	} = Vue;
	const base_url = "<?= base_url() ?>"
	const init = {
		setup() {
			const dataApi = reactive({});
			const fetchToday = async () => {
				showLoading()
				const todayRequest = await fetch(base_url + 'instrumen/today').then(res => res.json())
				dataApi.instrumen = todayRequest
				Swal.close()
			}

			onMounted(() => fetchToday());

			return {
				fetchToday,
				dataApi
			}
		}
	}
	const initialize = createApp(init)
	initialize.component('table-instrumen', {
		template: `	
			<table class="table table-responsive table-hover table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nomor Perkara</th>
						<th>Tanggal Sidang/Putus</th>
						<th>Jenis Panggilan</th>
						<th>Pihak</th>
						<th>Biaya</th>
						<th>Relaas</th>
					</tr>
				</thead>
				<tbody>
          <tr v-if="instrumen.length > 0" v-for="ins,index in instrumen" :key="ins.id">
						<td>{{++index}}</td>
						<td>{{ins.nomor_perkara}}</td>
						<td>{{toFullDate(ins.tanggal_sidang)}}</td>
						<td>{{ins.jenis_panggilan}}</td>
						<td><strong>{{ins.pihak}}</strong><br>{{ins.alamat_pihak}}</td>
						<td>
							<p v-if="ins.biaya"> {{ins.biaya}}</p>
							<button v-else class="btn btn-sm btn-success">Isi Biaya</button>
            </td>
            <td>
							<a target="_blank" :href="base_url + 'instrumen/cetak/' + ins.id" class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-font"></i>
							</a>
						</td>
					</tr>
					<tr v-else>
						<td colspan="7" class="text-center">Tidak Ada Data</td>
					</tr>
				</tbody>
			</table>`,
		props: {
			instrumen: {
				type: Array,
				default: []
			}
		},
		setup(props, context) {
			function toFullDate(date) {
				return moment(date, 'YYYY/MM/DD').locale('id').format('dddd LL')
			}

			return {
				toFullDate,
				base_url
			}
		}
	})
	initialize.mount('#vue')
</script>