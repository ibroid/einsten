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
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jurusita</th>
                  <th>Total Relaas</th>
                  <th>Total Pencarian</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="j, index in listJurusita" :key="j.id">
                  <td>{{++index}}</td>
                  <td>{{j.nama}}</td>
                  <td><span class="badge bg-primary"></span>{{j.instrumen.length}}</td>
                  <td>{{uraiBiaya(j.instrumen, potongan)}}</td>
                </tr>
              </tbody>

            </table>
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
        console.log(requestListJurusita)
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