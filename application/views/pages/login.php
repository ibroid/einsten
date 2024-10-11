<div class="auth-logo">
  <a href="#"><img src="<?= base_url($_ENV['LOGO']) ?>" alt="Logo"></a>
</div>
<h1 class="auth-title">Log in.</h1>
<p class="auth-subtitle ">Selamat Datang di Aplikasi EINSTEN.</p>
<p>E-Instrumen Pengadilan Agama <?= ucwords(strtolower(sysconf()->NamaPN))  ?? "Tingkat Pertama" ?></p>

<form
  hx-post="<?= base_url('login') ?>"
  autocomplete="off"
  hx-target="#auth-alert"
  hx-on::before-request="$('#login-button').prop('disabled', true)"
  hx-on::after-request="$('#login-button').prop('disabled', false)">
  <div class="form-group position-relative has-icon-left mb-4">
    <input type="text" required name="username" class="form-control form-control-xl" placeholder="User SIPP">
    <div class="form-control-icon">
      <i class="bi bi-person"></i>
    </div>
  </div>
  <div class="form-group position-relative has-icon-left mb-4">
    <input type="password" required name="password" class="form-control form-control-xl" placeholder="Password">
    <div class="form-control-icon">
      <i class="bi bi-shield-lock"></i>
    </div>
  </div>
  <button id="login-button" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
    <i class="bi bi-plus"></i>
    Log in
  </button>
</form>

<div id="auth-alert">

</div>