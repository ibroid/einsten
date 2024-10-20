<div class="content-wrapper container">
  <?php
  $year = date('Y');
  $minYear =  date("Y", strtotime("-3 year"));
  ?>
  <div class="page-heading">
    <h3>Buat Instrumen</h3>
  </div>
  <div class="page-content">
    <div id="vue">
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              Buat Instrumen
            </h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <input autofocus v-model="inputValue.nomorPerkara" type="number" placeholder="Nomor Perkara ..." class="form-control form-control-lg">
              </div>
              <div class="col-md-3">
                <select v-model="inputValue.jenisPerkara" class="form-control form-control-lg">
                  <option>Pdt.G</option>
                  <option>Pdt.P</option>
                </select>
              </div>
              <div class="col-md-3">
                <select v-model="inputValue.tahunPerkara" class="form-control form-control-lg">
                  <?php for ($i = $year; $i > $minYear; $i--) { ?>
                    <option><?= $i ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3">
                <button v-on:click="search()" class="btn btn-lg btn-success btn-block">
                  <i class="bi bi-search">
                  </i>
                  Cari
                </button>
              </div>
            </div>
            <hr>
            <alert-putusan v-if="showAlertPutusan" :putusan="dataApi.putusan" @pilih_pip="handlePIP"></alert-putusan>
            <table-jadwal-sidang v-if="showTableJadwalSidang" :sidang="dataApi.jadwal_sidang" @pilih_sidang="handleSidang"></table-jadwal-sidang>
          </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Buat Instrumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered" v-if="showTableJadwalSidang">
                  <thead>
                    <tr class="bg-dark text-white">
                      <th class="text-center">Pihak Penggugat/Pemohon</th>
                      <th class="text-center">Pihak Tergugat/Termohon</th>
                    </tr>
                    <tr>
                      <th>
                        <ul v-for="ps in dataApi.pihak_satu">
                          <li>{{ps.nama}}</li>
                          <li>{{ps.alamat}}</li>
                          <li>
                            <button v-on:click="kirimInstrumen(ps, 1)" class="btn btn-sm btn-success">Kirim Instrumen</button>
                            <button v-on:click="kirimDelegasi(ps, 1)" class="btn btn-sm btn-danger">Kirim Delegasi</button>
                          </li>
                        </ul>
                      </th>
                      <th>
                        <ul v-for="pd in dataApi.pihak_dua">
                          <li>{{pd.nama}}</li>
                          <li>{{pd.alamat}}</li>
                          <li>
                            <button v-on:click="kirimInstrumen(pd, 2)" class="btn btn-sm btn-success">Kirim Instrumen</button>
                            <button v-on:click="kirimDelegasi(pd, 2)" class="btn btn-sm btn-danger">Kirim Delegasi</button>
                          </li>
                        </ul>
                      </th>
                    </tr>
                  </thead>
                </table>
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
  <div class="page-heading">
    <h3>Rekomendasi Dibuatkan Instrumen</h3>
  </div>
  <div class="page-content">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            <h5>Tabel Perkara Tundaan Sidang Hari Ini</h5>
          </div>
          <table id="table-suggest-one" class="table table-hover">
            <thead>
              <tr>
                <th>Nomor Perkara</th>
                <th>Para Pihak</th>
                <th>Alasan Ditunda</th>
                <th>Dihadiri Oleh</th>
                <th>Ditunda Ke Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody
              id="tbody-tundaan-sidang"
              hx-get="<?= base_url('instrumen_sidang/tbody_tundaan_sidang') ?>" hx-trigger="load, fetchTundaanSidang">

            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>

<div
  class="modal fade"
  id="modalId"
  tabindex="-1"
  data-bs-keyboard="false"
  data-bs-backdrop="static"

  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true">
  <div
    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">
          Form Buat Instrumen Tundaan Sidang
        </h5>
        <button
          onclick="datePickerDestroy()"
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-body-formtundaan">
        <div class="text-center">
          <h2>Mohon Tunggu ... </h2>
        </div>
      </div>
      <div class="modal-footer">
        <button
          onclick="datePickerDestroy()"
          type="button"
          class="btn btn-dark"
          data-bs-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>




<script>
  var datePickerInstance;

  document.addEventListener('refetchTundaanSidang', () => {
    htmx.trigger("#tbody-tundaan-sidang", "fetchTundaanSidang")
  })
  document.addEventListener('datepickerInit', datePickerInit)
  document.addEventListener('datatableInit', () => {
    $('#table-suggest-one').DataTable();
  })

  function datePickerInit() {
    datePickerInstance = flatpickr(".datepicker-swap");
  }

  function datePickerDestroy() {

    if (datePickerInstance) {
      datePickerInstance.destroy()
    }
  }

  window.addEventListener("load", function() {

    $("#modalId").on('hide.bs.modal', () => {
      $("#modal-body-formtundaan").html(` <div class="text-center"><h2>Mohon Tunggu ... </h2></div>`)
    })

    myStorage = window.localStorage;

    function toFullDate(date) {
      return moment(date, 'YYYY/MM/DD').locale('id').format('dddd LL')
    }

    window.addEventListener('DOMContentLoaded', (event) => {
      myStorage.clear()
    });

    const base_url = "<?= base_url() ?>"
    const {
      createApp,
      onMounted,
      reactive,
      component,
      ref
    } = Vue;

    const init = {
      setup() {
        const showTableJadwalSidang = ref(false)
        const showAlertPutusan = ref(false)

        const instrumenValue = reactive({
          sidang_id: '',
          jurusita_id: '',
          jurusita_nama: '',
          tanggal_sidang: '',
          agenda: '',
          nomor_perkara: '',
          perkara_id: '',
          pihak: '',
          biaya: '',
          pihak_id: '',
          alamat_pihak: '',
          jenis_panggilan: '',
          jenis_pihak: ''
        })

        const date = new Date();

        const dataApi = reactive({
          pihak_satu: [],
          pihak_dua: [],
          putusan: {}
        })

        const inputValue = reactive({
          nomorPerkara: '',
          jenisPerkara: 'Pdt.G',
          tahunPerkara: date.getFullYear(),
        })

        const search = async () => {

          showTableJadwalSidang.value = false
          showAlertPutusan.value = false

          if (inputValue.nomorPerkara == '') {
            return Swal.fire('Nomor Perkara masih kosong')
          }

          const body = new FormData()
          body.append('nomor_perkara', inputValue.nomorPerkara)
          body.append('jenis_perkara', inputValue.jenisPerkara)
          body.append('tahun_perkara', inputValue.tahunPerkara)

          Swal.fire({
            text: "Mohon Tunggu",
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading()
            },
            allowOutsideClick: () => !Swal.isLoading(),
            backdrop: true
          })
          const searchRequest = await fetch(base_url + 'search/perkara', {
              method: 'POST',
              body: body
            })
            .then(res => res.json())
            .catch(err => console.error(err));

          console.log(searchRequest)

          if (searchRequest === null) {
            Swal.fire('Nomor Perkara Tidak Ditemukan')
          } else {

            if (searchRequest.putusan) {
              showAlertPutusan.value = true
              dataApi.putusan = searchRequest.putusan
            }

            instrumenValue.nomor_perkara = searchRequest.nomor_perkara
            instrumenValue.perkara_id = searchRequest.perkara_id
            dataApi.pihak_satu = searchRequest.pihak_satu
            dataApi.pihak_dua = searchRequest.pihak_dua
            dataApi.jurusita = searchRequest.jurusita
            dataApi.jadwal_sidang = searchRequest.jadwal_sidang

            showTableJadwalSidang.value = true

            Swal.close()
          }
        }

        const kirimInstrumen = async (pihak, jenis_pihak) => {
          findRadius(pihak.alamat);
          instrumenValue.jenis_pihak = jenis_pihak
          instrumenValue.pihak = pihak.nama
          instrumenValue.pihak_id = pihak.pihak_id
          instrumenValue.alamat_pihak = pihak.alamat
          const inputOption = {}
          dataApi.jurusita.forEach(row => {
            inputOption[row.jurusita_id] = row.jurusita_nama
          });
          const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
              resolve(inputOption)
            }, 1000)
          });

          const {
            value: jurusita
          } = await Swal.fire({
            title: 'Pilih Jurusita',
            input: 'radio',
            inputOptions: inputOptions,
            inputPlaceholder: 'Pilih Jurusita',
            showCancelButton: true,
            inputValidator: (value) => {
              return new Promise((resolve) => {
                if (value) {
                  resolve()
                } else {
                  resolve('Pilih Salah Satu')
                }
              })
            }
          })

          if (jurusita) {
            const jurusitaTerpilih = dataApi.jurusita.find(row => row.jurusita_id == jurusita)
            instrumenValue.jurusita_nama = jurusitaTerpilih.jurusita_nama
            instrumenValue.jurusita_id = jurusitaTerpilih.jurusita_id
            saveInstrumen()
          }
        }

        const kirimDelegasi = async (pihak, jenis_pihak) => {
          Swal.fire({
            icon: 'question',
            title: 'Instrumen Panggilan Luar',
            text: 'Buat instrumen untuk delegasi ?',
            inputAttributes: {
              autocapitalize: 'on'
            },
            showCancelButton: true,
            confirmButtonText: 'Buat',
          }).then((result) => {
            if (result.isConfirmed) {
              instrumenValue.jenis_pihak = jenis_pihak
              instrumenValue.pihak = pihak.nama
              instrumenValue.pihak_id = pihak.pihak_id
              instrumenValue.alamat_pihak = pihak.alamat
              instrumenValue.jurusita_nama = 'Kordinator Delegasi'
              instrumenValue.jurusita_id = 0
              saveInstrumen()
            }
          })

        }

        const findRadius = async (alamat) => {
          const radiusRequest = await fetch(base_url + 'radius').then(res => res.json())
          if (radiusRequest) {
            radiusRequest.forEach(element => {
              let check = String(alamat).toUpperCase().includes(element.kelurahan.toUpperCase())
              if (check == true) {
                instrumenValue.biaya = element.biaya
              }
            });
          }
        }

        const handlePIP = (date) => {
          instrumenValue.tanggal_sidang = date
          instrumenValue.jenis_panggilan = 'Pemberitahuan Isi Putusan'
          instrumenValue.agenda = 'Pemberitahuan Isi Putusan'
          instrumenValue.sidang_id = 0
        }

        const handleSidang = (sidang) => {
          console.log(sidang)
          instrumenValue.sidang_id = sidang.id
          instrumenValue.tanggal_sidang = sidang.tanggal_sidang
          instrumenValue.agenda = sidang.agenda

          if (sidang.urutan == 1) {
            instrumenValue.jenis_panggilan = 'Sidang Pertama'
          } else {
            if (sidang.ikrar_talak == 'Y') {
              instrumenValue.jenis_panggilan = 'Sidang Ikrar Talak'
            } else {
              instrumenValue.jenis_panggilan = 'Sidang Lanjutan'
            }
          }
        }


        const saveInstrumen = async () => {
          const body = new FormData();
          for (const iterator in instrumenValue) {
            if (Object.hasOwnProperty.call(instrumenValue, iterator)) {
              const element = instrumenValue[iterator];
              body.append(iterator, element)
            }
          }
          try {
            const postRequest = await fetch(base_url + 'instrumen', {
                method: 'POST',
                body: body,
              })
              .then(res => res.json())
            Swal.fire({
              title: 'Berhasil',
              text: 'Apa anda akan membuat instrumen lagi ??',
              showCancelButton: true,
              confirmButtonText: 'Buat lagi'
            }).then(result => (!result.isConfirmed) ? location.href = base_url + 'instrumen_sidang/daftar' : false);
          } catch (error) {
            Swal.fire({
              title: 'Error',
              text: error,
              icon: 'error'
            })
          }
        }

        return {
          search,
          inputValue,
          showTableJadwalSidang,
          showAlertPutusan,
          dataApi,
          kirimInstrumen,
          handlePIP,
          handleSidang,
          kirimDelegasi
        }

      }
    }

    const initialize = createApp(init)

    initialize.component('alert-putusan', {
      template: `	
			<div class="alert alert-success">
				<strong>Perkara Ini Sudah Putus Pada Tanggal {{tanggalPutus}}</strong>
				<p>Silahkan Buat Instrumen Pemberitahuan Isi Putusan Disini</p>
				<button :click="pilihpip()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-calendar2-plus-fill"></i>
				Buat Instrumen PIP
				</button>
			</div>`,
      props: {
        putusan: {
          type: Object
        }
      },
      setup(props, context) {
        const tanggalPutus = toFullDate(props.putusan.tanggal_putusan);

        const pilihpip = () => {
          context.emit('pilih_pip', props.putusan.tanggal_putusan)
        }

        return {
          tanggalPutus,
          pilihpip
        }
      }
    })

    initialize.component('table-jadwal-sidang', {
      template: `
			<table class="table table-responsive table-bordered table-hover">
				<thead>
					<tr class="bg-dark text-white">
						<th>No</th>
						<th>Tanggal Sidang</th>
						<th>Agenda</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="d,index in sidang" :key="d.id">
						<td>{{++index}}</td>
						<td>{{toFullDate(d.tanggal_sidang)}}</td>
						<td>{{d.agenda}}</td>
						<td class="text-center">
							<button v-on:click="pilihSidang(d)" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary btn-sm">
								<i class="bi bi-calendar2-plus-fill"></i> Buat Instrumen
							</button>
						</td>
					</tr>
				</tbody>
			</table>`,
      props: {
        sidang: {
          type: Array,
          default: []
        }
      },
      setup(props, context) {
        const pilihSidang = (sidang) => {
          context.emit('pilih_sidang', sidang);
        }

        return {
          pilihSidang,
          toFullDate
        }
      }
    })

    initialize.mount('#vue')
  });
</script>