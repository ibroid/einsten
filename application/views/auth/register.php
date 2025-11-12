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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
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
            </header>
            <div class="content-wrapper container">
                <a href="<?= base_url() ?>">Kembali ke Login</a>
                <center>
                    <h2>Register Akun</h2>
                </center>
                <div class="page-content">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Akun Panitera</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Akun Jurusita</button>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="card-title">Pastikan sudah mengisi nomor hape pada Kolom "Keterangan" di referensi Jurusita SIPP</h1>
                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Panitera</th>
                                                <th>NIP</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($panitera as $pk => $pv) { ?>
                                                <tr>
                                                    <td><?= ++$pk ?></td>
                                                    <td><?= $pv->nama_gelar ?></td>
                                                    <td><?= $pv->nip ?></td>
                                                    <td>
                                                        <button onclick=" generateAkun(<?= $pv->id ?>, 6) " class="btn btn-primary btn-sm">Generate Akun</button>
                                                        <button onclick="hapusAkun()" class="btn btn-danger btn-sm">Hapus Akun</button>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="card-title">Pastikan sudah mengisi nomor hape pada Kolom "Keterangan" di referensi Jurusita SIPP</h1>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-responsive table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jurusita</th>
                                                <th>NIP</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($jurusita as $pk => $pv) { ?>
                                                <tr>
                                                    <td><?= ++$pk ?></td>
                                                    <td><?= $pv->nama_gelar ?></td>
                                                    <td><?= $pv->nip ?></td>
                                                    <td>
                                                        <button onclick=" generateAkun(<?= $pv->id ?>, 7) " class="btn btn-primary btn-sm">Generate Akun</button>
                                                        <button onclick="hapusAkun()" class="btn btn-danger btn-sm">Hapus Akun</button>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; PAJU</p>
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
    <script>
        const swloading = () => {
            Swal.fire({
                title: "Mohon tunggu",
                didOpen() {
                    return Swal.showLoading()
                },
                backdrop: true,
                allowOutsideClick: false
            })
        }
        const generateAkun = (id, jenis) => {
            swloading()

            const body = new FormData();
            body.append('id', id)
            body.append('jenis', jenis)

            fetch("<?= base_url('register/generate') ?>", {
                    method: "POST",
                    body
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(res.statusText)
                    }
                    return res.json()
                })
                .then(res => {
                    Swal.fire(res.status, res.message, 'info').
                    then(res => {
                        location.reload()
                    })
                })
                .catch(err => {
                    Swal.fire('Terjadi Kesalahan', err.message, 'error')
                })

        }

        const hapusAkun = (id) => {
            Swal.fire("Perhatian", "Akun ini tidak bisa dihapus", "warning")

        }
    </script>

</body>

</html>