<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('static/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('static/favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('static/favicon/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('static/favicon/site.webmanifest') ?>">

    <title>Login - EINSTEN</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/pages/auth.css">
    <?php foreach ($css_addons as $css) { ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php }  ?>

</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-6 col-12">
                <div id="auth-left">
                    <?= $content ?>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>
</body>
<?php foreach ($js_plugins as $js) { ?>
    <script src="<?= $js ?>"></script>
<?php } ?>

</html>