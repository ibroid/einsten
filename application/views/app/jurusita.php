<div class="content-wrapper container">
	<div class="page-heading">
		<h4>Instrumen</h4>
	</div>
	<div class="page-content">
		<div id="vue">
			<section>
				<div class="card blue-grey darken-1">
					<div class="card-body">
						<h4 class="card-title">{{filtername}}</h4>
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-sm btn-primary">
									<i class="bi bi-calendar"></i>
									Instrumen Hari Ini
								</button>
								<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-sm btn-success">
									<i class="bi bi-filter-square"></i>
									Cari Instrumen
								</button>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-sm-6">
										<input type="date" v-model="searchValue.tanggal_sidang" class="form-control">
									</div>
									<div class="col-sm-6">
										<button v-on:click="cari_berdasarkan_tgl_sidang()" class="btn btn-sm btn-danger">
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
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												<input type="date" class="form-control" v-model="searchValue.tanggal_diterima">
											</th>
											<th>
												<button v-on:click="cari_berdasarkan_tgl_diterima()" class="btn btn-success btn-sm">Cari berdasarkan Tanggal Diterima</button>
											</th>
										</tr>
										<tr>
											<th>
												<input id="listperkara" placeholder="Nomor Perkara" type="text" class="form-control" v-model="searchValue.nomor_perkara">
												<datalist id="listperkara">
												</datalist>
											</th>
											<th>
												<button v-on:click="() => cari_instrumen('nomor_perkara', searchValue.nomor_perkara)" class="btn btn-success btn-sm">Cari berdasarkan Nomor Perkara</button>
											</th>
										</tr>
									</thead>
								</table>
							</div>
							<div class=" modal-footer">
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
	const toFullDate = (date) => {
		return moment(date, 'YYYY/MM/DD').locale('id').format('dddd LL')
	}
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
		onMounted,
		ref,
		watchEffect
	} = Vue;
	const base_url = "<?= base_url() ?>"
	const init = {
		setup() {
			const filtername = ref('Instrumen Hari Ini')
			const searchValue = reactive({
				tanggal_diterima: '',
				nomor_perkara: '',
				tanggal_sidang: ''
			})
			const dataApi = reactive({});
			const fetchToday = async () => {
				filtername.value = 'Instrumen Hari Ini'
				showLoading()
				const todayRequest = await fetch(base_url + 'instrumen/today').then(res => res.json())
				dataApi.instrumen = todayRequest
				Swal.close()
			}

			onMounted(() => fetchToday());

			const cari_instrumen = async (params, value) => {
				showLoading()
				const body = new FormData()
				body.append(params, value)
				const searchRequest = await fetch(base_url + 'instrumen/search', {
					method: 'POST',
					body: body
				}).then(res => res.json())
				dataApi.instrumen = searchRequest
				Swal.close()
			}

			const cari_berdasarkan_tgl_sidang = () => {
				if (searchValue.tanggal_sidang) {
					filtername.value = 'Instrumen Tanggal Sidang Berdasarkan ' + toFullDate(searchValue.tanggal_sidang)
					cari_instrumen('tanggal_sidang', searchValue.tanggal_sidang)
				}
			}

			const cari_berdasarkan_tgl_diterima = () => {
				if (searchValue.tanggal_diterima) {
					filtername.value = 'Instrumen Diterima Berdasarkan ' + toFullDate(searchValue.tanggal_diterima)
					cari_instrumen('tanggal_diterima', searchValue.tanggal_diterima)
				}
			}

			const cari_berdasarkan_nomor_perkara = () => {
				if (searchValue.nomor_perkara) {
					filtername.value = 'Instrumen Berdasarkan Nomor Perkara'
					cari_instrumen('nomor_perkara', searchValue.nomor_perkara)
				}
			}

			const watchNomorPerkara = watchEffect(() => {
				console.log(searchValue.nomor_perkara)
			})

			return {
				fetchToday,
				dataApi,
				searchValue,
				cari_instrumen,
				filtername,
				cari_berdasarkan_tgl_diterima,
				cari_berdasarkan_tgl_sidang,
				cari_berdasarkan_nomor_perkara,
				watchNomorPerkara
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
						<td><strong>{{ins.nomor_perkara}}</strong><br>{{difHuman(ins.created_at)}}</td>
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

			function difHuman(date) {
				return moment(date, 'YYYY/MM/DD').locale('id').fromNow()
			}

			return {
				toFullDate,
				base_url,
				difHuman
			}
		}
	})
	initialize.component('option-perkara', {
		template: `<option></option>`,
		props: ['nomor_perkara']
	})
	initialize.mount('#vue')
</script>