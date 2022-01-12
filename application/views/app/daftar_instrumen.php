<div class="content-wrapper container">
	<div class="page-heading">
		<h3>Daftar Instrumen</h3>
	</div>
	<div class="page-content">
		<div id="vue">
			<section>
				<div class="card">
					<div class="card-header">
						<h1 class="card-title">Daftar Instrumen Hari Ini</h1>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-sm btn-primary" v-on:click="fetchToday()">
									<i class="bi bi-calendar"></i>
									Daftar Hari Ini
								</button>
								<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-sm btn-success">
									<i class="bi bi-filter-square"></i>
									Filter Data
								</button>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-sm-6">
										<input type="date" v-model="searchValue.byTanggalSidang" class="form-control">
									</div>
									<div class="col-sm-6">
										<button class="btn btn-sm btn-danger" v-on:click="fetchByDate()">
											<i class="bi bi-filter-square"></i>
											Cari Berdasarkan Tanggal Sidang
										</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<table-instrumen @findrelaas="handleFindRelaas" :instrumen="dataApi.instrumen"></table-instrumen>
					</div>
				</div>
				<div ref="refModal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<component :is="bodyModal"></component>
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

	const base_url = "<?= base_url() ?>";
	const {
		createApp,
		onMounted,
		reactive,
		ref
	} = Vue;

	const init = {
		setup() {
			const bodyModal = ref('table-filter');
			const dataApi = reactive({});
			const searchValue = reactive({
				byTanggalSidang: '',
				byNomorPerkara: '',
				byJurusita: '',
				byJenisPanggilan: '',
			});

			function handleFindRelaas(sidang_id) {
				// bodyModal.value = 
			}

			const refModal = ref(null);

			const fetchToday = async () => {
				showLoading()
				const todayRequest = await fetch(base_url + 'instrumen/today').then(res => res.json())
				dataApi.instrumen = todayRequest
				Swal.close()
			}

			const fetchByDate = async () => {
				showLoading()
				const body = new FormData()
				body.append('date', searchValue.byTanggalSidang);
				const dateRequest = await fetch(base_url + 'instrumen/by_date', {
					method: 'POST',
					body: body
				}).then(res => res.json())
				dataApi.instrumen = dateRequest
				Swal.close()
			}

			onMounted(() => fetchToday());
			return {
				dataApi,
				fetchToday,
				searchValue,
				fetchByDate,
				refModal,
				bodyModal,
				handleFindRelaas
			}
		}
	}

	const initialize = createApp(init)

	initialize.component('table-filter', {
		template: `	
			<table class="table table-responsive table-hover">
				<thead>
					<tr>
						<th><input v-model="searchValue.byNomorPerkara" type="text" placeholder="Nomor Perkara" class="form-control"></th>
						<th><button class="btn btn-success btn-sm">Cari Berdasarkan Nomor Perkara</button></th>
					</tr>
					<tr>
						<th>
							<select v-model="searchValue.byJurusita" class="form-control">
								<?php foreach ($jurusita as $js) { ?>
									<option value="<?= $js->id ?>"><?= $js->nama_gelar ?> </option>
								<?php } ?>
							</select>
						</th>
						<th><button class="btn btn-success btn-sm">Cari Berdasarkan Jurusita</button></th>
					</tr>
					<tr>
						<th>
							<select v-model="searchValue.byJenisPanggilan" class="form-control">
								<option selected>Panggilan Sidang Pertama</option>
								<option>Panggilan Sidang Lanjutan</option>
								<option>Panggilan Sidang Ikrar</option>
								<option>Panggilan Pemberitahuan Isi Putusan </option>
							</select>
						</th>
						<th><button class="btn btn-success btn-sm">Cari Berdasarkan Jenis Panggilan</button></th>
					</tr>
				</thead>
			</table>`,
		setup() {
			const searchValue = reactive({
				byTanggalSidang: '',
				byNomorPerkara: '',
				byJurusita: '',
				byJenisPanggilan: '',
			});

			return {
				searchValue
			}

		}
	})

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
						<th>Jurusita</th>
						<th>Relaas</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="instrumen.length > 0" v-for="ins,index in instrumen" :key="ins.id">
						<td>{{++index}}</td>
						<td>{{ins.nomor_perkara}}</td>
						<td>{{toFullDate(ins.tanggal_sidang)}}</td>
						<td>{{ins.jenis_panggilan}}</td>
						<td>{{ins.pihak}}</td>
						<td>{{ins.jurusita_nama}}</td>
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
			onMounted(() => {})

			function toFullDate(date) {
				return moment(date, 'YYYY/MM/DD').locale('id').format('dddd LL')
			}

			const findrelaas = (sidang_id) => {
				context.emit('findrelaas', sidang_id)
			}

			const hapusInstrumen = (id) => {
				Swal.fire({
					title: 'Perhatian',
					icon: 'warning',
					text: 'Apa anda yakin menghapus instrumen ini ?',
					showCancelButton: true,
					confirmButtonText: 'Yakin',
					showLoaderOnConfirm: true,
					backdrop: true,
					preConfirm: () => {
						const body = new FormData()
						body.append('id', id)
						return fetch(base_url + 'instrumen/delete', {
								method: 'POST',
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
									`Penghapusan Error: ${error}`
								)
							})
					},
					allowOutsideClick: () => !Swal.isLoading()
				}).then((result) => {
					if (result.isConfirmed) {
						console.log(result)
						const indx = props.instrumen.findIndex(row => row.id === id)
						props.instrumen.splice(indx, indx >= 0 ? 1 : 0);
						Swal.fire('Instrumen Berhasil di Hapus')
					}
				})
			}
			return {
				toFullDate,
				hapusInstrumen,
				findrelaas
			}
		}
	})


	initialize.mount('#vue')
</script>