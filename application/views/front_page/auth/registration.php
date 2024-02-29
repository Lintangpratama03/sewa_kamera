<!doctype html>
<html lang="en">

<head>
    <link href="<?= base_url('assets/image/icon.png') ?>" rel="icon">
    <title> MITRA | REGISTER </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/template-auth/css/style.css">

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">

    <style>
        body {
            background-image: url('<?= base_url('assets/image/back.jpg') ?>');
            background-size: cover;
        }
    </style>

</head>

<body>
    <section class="ftco-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="wrap row">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="w-100">
                                <h3 class="mb-4" align="center">FORM DAFTAR MITRA</h3>
                            </div>
                            <!-- Form untuk Biodata dan Persyaratan -->
                            <form method="post" action="<?php echo base_url('registrasi'); ?>" class="signin-form" enctype="multipart/form-data">
                                <!-- Biodata -->
                                <div id="biodata-section">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="nama" class="label">Nama</label>
                                                <input type="text" class="form-control" placeholder="Masukkan Nama" name="nama" id="nama" value="<?= set_value('nama'); ?>">
                                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="username" class="label">Username (*digunakan Login)</label>
                                                <input type="text" class="form-control" placeholder="Masukkan username" name="username" id="username" value="<?= set_value('username'); ?>">
                                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="telepon" class="label">No HP</label>
                                                <input type="number" class="form-control" placeholder="Masukkan Nomor HP" name="telepon" id="telepon" value="<?= set_value('telepon'); ?>">
                                                <?= form_error('telepon', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="email" class="label">Email</label>
                                                <input type="text" class="form-control" placeholder="Masukkan Email" name="email" id="email" value="<?= set_value('email'); ?>">
                                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="password" class="label">Password</label>
                                                <input type="password" class="form-control" placeholder="Masukkan password" name="password" id="password">
                                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="password1" class="label">Ulangi Password</label>
                                                <input type="password" class="form-control" placeholder="Ulangi password" name="password1" id="password1">
                                                <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-md-flex">
                                        <div class="w-50 text-left">
                                            <label class="checkbox-wrap checkbox-primary mb-0" for="showPasswordCheckbox">Lihat password
                                                <input type="checkbox" id="showPasswordCheckbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <button type="button" class="btn btn-primary btn-lg" onclick="showPersyaratanForm()">Lanjutkan ke Persyaratan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Persyaratan -->
                                <div id="persyaratan-section" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="label">Persyaratan</label>
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Foto Usaha</label>
                                                    <input type="file" class="form-control" name="image" id="image" onchange="previewImage(event, 'imagePreview')">
                                                    <small class="text-danger pl-1"><?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?></small>
                                                    <div id="imagePreview" class="mt-2"></div>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="ktp" class="form-label">KTP</label>
                                                    <input type="file" class="form-control" name="ktp" id="ktp" onchange="previewImage(event, 'ktpPreview')">
                                                    <small class="text-danger pl-1"><?= form_error('ktp', '<small class="text-danger pl-3">', '</small>'); ?></small>
                                                    <div id="ktpPreview" class="mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-center">
                                            <a class="btn btn-danger btn-lg text-white" href="<?= base_url('') ?>">Sudah punya akun?</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showPersyaratanForm() {
            document.getElementById('biodata-section').style.display = 'none';
            document.getElementById('persyaratan-section').style.display = 'block';
        }
    </script>
    <script src=" <?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/main.js"></script>
    <script>
        var base_url = '<?php echo base_url() ?>';
        var _controller = '<?= $this->router->fetch_class() ?>';
    </script>
</body>

</html>