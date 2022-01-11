<div class="auth-logo">
    <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
</div>
<h1 class="auth-title">Log in.</h1>
<p class="auth-subtitle ">Selamat Datang di Aplikasi EINSTEN.</p>
<p>E-Instrumen Pengadilan Agama Jakarta Utara</p>

<div id="vue">
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="text" v-model="formValue.username" class="form-control form-control-xl" placeholder="Nomor Telepon">
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
    </div>
    <div hidden class="form-group position-relative has-icon-left mb-4">
        <input type="hidden" value="paju" class="form-control form-control-xl" placeholder="Password">
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
    </div>
    <button v-on:click="handleSubmit()" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
        <i class="bi bi-plus"></i>
        Log in
    </button>
</div>
<script src="<?= base_url('assets/js/vue/dist/vue.global.js') ?>"></script>
<script>
    const base_url = "<?= base_url() ?>";
    const {
        createApp,
        reactive
    } = Vue

    const init = {
        setup() {
            const formValue = reactive({
                username: '',
                password: 'paju',
            })

            const handleSubmit = async () => {

                Swal.fire({
                    text: "Mohon Tunggu",
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                    backdrop: true
                })

                const body = new FormData()
                body.append('username', formValue.username)
                body.append('password', formValue.password)
                const loginRequest = await fetch(base_url + 'auth/login', {
                    method: 'POST',
                    body: body
                }).then(res => res.json())

                console.log(loginRequest);

                if (loginRequest === null) {
                    return Swal.fire('Akun atau Password Salah');
                } else {
                    return Swal.fire({
                        title: 'Berhasil Login!',
                        text: `Selamat Datang ${loginRequest.nama_gelar}`,
                        confirmButtonText: 'Lanjutkan',
                        allowOutsideClick: false,
                        backdrop: true
                    }).then(() => location.href = base_url + 'app')
                }
            }

            return {
                formValue,
                handleSubmit
            }
        }
    }
    const initialize = createApp(init)
    initialize.mount('#vue')
</script>