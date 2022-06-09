<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'EINSTEN' ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/simple-datatables/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.svg" type="image/x-icon">
    <script src="<?= base_url('assets/js/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="index.html"><img src="<?= base_url() ?>assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="header-top-right">
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <ul>
                            <?php if (auth()->user->level_id == 7) { ?>
                                <li class="menu-item">
                                    <a href="<?= base_url('app') ?>" class='menu-link'>
                                        <i class="bi bi-grid-fill"></i>
                                        <span>Instrumen</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (auth()->user->level_id == 6) { ?>
                                <li class="menu-item has-sub">
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
                            <?php } ?>
                            <?php if (isset(auth()->kasir)) { ?>
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
                            <?php } ?>
                            <li class="menu-item">
                                <a href="#" class='menu-link'>
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?= base_url('auth/logout') ?>" class='menu-link'>
                                    <i class="bi bi-door-open-fill"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

            </header>

            <?= $contents ?>

            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; PAJU</p>
                        </div>
                        <div class="float-end">
                            <p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="http://pa-jakartautara.go.id">Maliki</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pages/horizontal-layout.js"></script>

</body>

</html>