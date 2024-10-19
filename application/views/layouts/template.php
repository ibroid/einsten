<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? $title . ' | EINSTEN' : 'EINSTEN' ?></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('static/favicon/apple-touch-icon.png') ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('static/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('static/favicon/favicon-16x16.png') ?>">
	<link rel="manifest" href="<?= base_url('static/favicon/site.webmanifest') ?>">

	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/iconly/bold.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/fontawesome/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/simple-datatables/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">

	<?php foreach ($css_addons as $css) { ?>
		<link rel="stylesheet" href="<?= $css ?>">
	<?php } ?>
</head>

<body>
	<div id="app">
		<div id="main" class="layout-horizontal">
			<header class="mb-5">
				<div class="header-top" style="padding: 0 !important;">
					<div class="container">
						<div class="logo">
							<a href="index.html">
								<img src="<?= base_url($_ENV['LOGO']) ?>" alt="Logo" srcset="">
							</a>
						</div>
						<div class="header-top-right">
							<h6><?= $this->userdata->fullname ?>
								| <small class="mt-0"><?= $this->userdata->name ?></small>
							</h6>
						</div>
					</div>
				</div>
				<nav class="main-navbar">
					<div class="container">
						<ul>
							<li class="menu-item">
								<a href="<?= base_url($beranda_link) ?>" class='menu-link'>
									<i class="bi bi-grid"></i>
									<span>Beranda</span>
								</a>
							</li>
							<?php foreach ($menus as $m) { ?>
								<li class="menu-item <?= $m->menu->is_sub ?>">
									<a href="<?= !$m->menu->is_sub ? base_url($m->menu->link) : "javascript:void(0)" ?>" class='menu-link'>
										<i class="<?= $m->menu->icon ?>"></i>
										<span><?= $m->menu->menu_name ?></span>
									</a>
									<?php if ($m->menu->is_sub) { ?>
										<div class="submenu ">
											<div class="submenu-group-wrapper">
												<ul class="submenu-group">
													<?php foreach ($m->menu->sub_menu as $sub_menu) { ?>
														<li class="submenu-item  ">
															<a href="<?= base_url($sub_menu->link) ?>" class='submenu-link'>
																<?= $sub_menu->sub_menu_name ?>
															</a>
														</li>
													<?php } ?>
												</ul>
											</div>
										</div>
									<?php } ?>
								</li>
							<?php } ?>
							<!-- <li class="menu-item has-sub">
								<a href="#" class='menu-link'>
									<i class="bi bi-grid-fill"></i>
									<span>Instrumen</span>
								</a>
								<div class="submenu ">
									<div class="submenu-group-wrapper">
										<ul class="submenu-group">
											<li class="submenu-item  ">
												<a href="<?= base_url('app') ?>" class='submenu-link'>Buat Instrumen</a>
											</li>
											<li class="submenu-item  ">
												<a href="<?= base_url('app/daftar') ?>" class='submenu-link'>
													Daftar Instrumen
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							 <li class="menu-item">
								<a href="<?= base_url('delegasi') ?>" class='menu-link'>
									<i class="bi bi-grid"></i>
									<span>Delegasi</span>
								</a>
							</li>
							<li class="menu-item has-sub">
								<a href="#" class='menu-link'>
									<i class="bi bi-cash"></i>
									<span>Keuangan</span>
								</a>
								<div class="submenu ">
									<div class="submenu-group-wrapper">
										<ul class="submenu-group">
											<li class="submenu-item  ">
												<a href="<?= base_url('pencairan') ?>" class='submenu-link'>Pencairan</a>
											</li>
											<li class="submenu-item  ">
												<a href="<?= base_url('app/daftar') ?>" class='submenu-link'>
													Potongan
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							<li class="menu-item has-sub">
								<a href="#" class='menu-link'>
									<i class="bi bi-display"></i>
									<span>Monitoring</span>
								</a>
								<div class="submenu ">
									<div class="submenu-group-wrapper">
										<ul class="submenu-group">
											<li class="submenu-item  ">
												<a href="<?= base_url('monitor/harian') ?>" class='submenu-link'>Instrumen Harian</a>
											</li>
											<li class="submenu-item  ">
												<a href="<?= base_url('monitor/penggunaan') ?>" class='submenu-link'>Total Penggunaan</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							<li class="menu-item">
								<a href="<?= base_url('setelan') ?>" class='menu-link'>
									<i class="bi bi-gear"></i>
									<span>Setelan</span>
								</a>
							</li>
							 -->
							<li class="menu-item">
								<form id="form--logout" action="<?= base_url('logout') ?>" method="post"></form>
								<a onclick="document.querySelector('#form--logout').submit()" href="javascript:void(0)" class='menu-link'>
									<i class="bi bi-door-open-fill"></i>
									<span>Logout</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>

			</header>

			<?= $content ?>

			<footer>
				<div class="container">
					<div class="footer clearfix mb-0 text-muted">
						<div class="float-start">
							<p>2021 &copy; </p>
						</div>
						<div class="float-end">
							<p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="https://mmaliki.my.id">Maliki</a></p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/js/pages/horizontal-layout.js"></script>
	<?php foreach ($js_plugins as $js) { ?>
		<script src="<?= $js ?>"></script>
	<?php } ?>

</body>

</html>