<div class="content-wrapper container">
	<div class="page-heading">
		<h4>Pencairan Relaas</h4>
	</div>
	<div class="page-container">
		<div id="vue">
			<section class="section">
				<div class="card">
					<div class="card-body">
						<h5>Total Relaas Hari Ini</h5>
						<ul class="list-group">
							<a href="#" class="list-group-item list-group-item-action">
								<li v-for="(js, index) in listJurusita" :key="js.id" class="list-group-item">{{++index}}. {{ js.nama_gelar }}
									<figure class="text-left">
										<span class="badge bg-success">Relaas : {{js.instrumen.length}}</span>

										<span class="badge bg-primary">Pencairan : {{uraiBiaya(js.instrumen, potongan)}}</span>
									</figure>
								</li>
							</a>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/vue/dist/vue.global.js') ?>"></script>
<script src="https://unpkg.com/vuex@4"></script>
<script src="<?= base_url('assets/js/moment/moment.js') ?>"></script>
<script>
	var base_url = "<?= base_url() ?>";
	const {
		createApp,
		onMounted,
		reactive,
		ref,
		computed,
		watch,
		watchEffect
	} = Vue;

	const {
		createStore,
		useStore
	} = Vuex;

	const store = createStore({
		state: {
			listJurusita: null,
		},
		mutations: {
			setListJurusita(state, payload) {
				state.listJurusita = payload
			},
		},
		actions: {
			async fetchListJurusita(context) {
				const requestListJurusita = await fetch(base_url + '/search/jurusita').then(res => res.json())
				context.commit('setListJurusita', requestListJurusita);
			},
		}
	})

	const initialize = createApp({
		setup() {
			const store = useStore();
			const potongan = ref([])
			const uraiBiaya = (data, potongan) => {
				potongan.forEach(element => {});
				let price = 0;
				return price;
			}

			const fetchPotongan = async () => {
				const requestPotongan = await fetch(base_url + '/search/potongan').then(res => res.json())
				potongan.value = requestPotongan
			}

			onMounted(() => {
				store.dispatch('fetchListJurusita')
				fetchPotongan()
			});

			return {
				uraiBiaya,
				listJurusita: computed(() => store.state.listJurusita),
				potongan
			}
		}
	})

	initialize.use(store);
	initialize.mount('#vue')
</script>