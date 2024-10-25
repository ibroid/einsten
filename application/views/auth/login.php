<div class="auth-logo">
	<a href="index.html"><img src="<?= base_url('assets/images/logo/logo.png') ?>" alt="Logo"></a>
</div>
<h1 class="auth-title">Log in.</h1>
<p class="auth-subtitle ">Selamat Datang di Aplikasi SIPAPI.</p>
<p>E-Instrumen Pengadilan Agama Jakarta Timur</p>

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