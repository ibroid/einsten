<div class="auth-logo">
  <a href="#"><img src="<?= base_url('assets/images/logo/logo.png') ?>" alt="Logo"></a>
</div>
<h1 class="auth-title">Log in.</h1>
<p class="auth-subtitle ">Selamat Datang di Aplikasi EINSTEN.</p>
<p>E-Instrumen Pengadilan Agama Jakarta Timur</p>

<form action="<?= base_url('login') ?>" method="post" autocomplete="off">
  <div class="form-group position-relative has-icon-left mb-4">
    <input type="text" name="username" class="form-control form-control-xl" placeholder="User SIPP">
    <div class="form-control-icon">
      <i class="bi bi-person"></i>
    </div>
  </div>
  <div class="form-group position-relative has-icon-left mb-4">
    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
    <div class="form-control-icon">
      <i class="bi bi-shield-lock"></i>
    </div>
  </div>
  <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
    <i class="bi bi-plus"></i>
    Log in
  </button>
</form>