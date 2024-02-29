<!doctype html>
<html lang="en">

<head>
    <link href="<?= base_url('assets/image/icon.png') ?>" rel="icon">
    <title>MITRA | LOGIN </title>
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

        .card {
            border: 1px solid #28a745;
        }

        .card-login {
            margin-top: 130px;
            padding: 18px;
            max-width: 30rem;
        }

        .card-header {
            color: #fff;
            /*background: #ff0000;*/
            font-family: sans-serif;
            font-size: 20px;
            font-weight: 600 !important;
            margin-top: 10px;
            border-bottom: 0;
        }

        .input-group-prepend span {
            width: 50px;
            background-color: #ff0000;
            color: #fff;
            border: 0 !important;
        }

        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;
        }

        .login_btn {
            width: 130px;
        }

        .login_btn:hover {
            color: #fff;
            background-color: #ff0000;
        }

        .btn-outline-danger {
            color: #fff;
            font-size: 18px;
            background-color: #28a745;
            background-image: none;
            border-color: #28a745;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1.2rem;
            line-height: 1.6;
            color: #28a745;
            background-color: transparent;
            background-clip: padding-box;
            border: 1px solid #28a745;
            border-radius: 0;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .input-group-text {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.6;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0;
        }
    </style>

</head>

<body>
    <section class="ftco-section">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <div class="container">
            <div class="card card-login mx-auto text-center bg-dark mt-5">
                <div class="card-header mx-auto bg-dark">
                    <span> <img src="<?= base_url('assets/image/icon.png') ?>" class="w-75" alt="Logo"> </span><br />
                    <span class="logo_title mt-5"> Login Dashboard MITRA</span>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('message'); ?>
                    <form method="post" action="<?php echo base_url('mitra'); ?>" class="signin-form">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Masukkan username" id="username" name="username" value="<?= set_value('username'); ?>" style="width: 300px;">
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Masukkan password" id="password" name="password" style="width: 300px;">
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50 text-left">
                                <label class="checkbox-wrap checkbox-primary mb-0" for="showPasswordCheckbox">Lihat password
                                    <input type="checkbox" id="showPasswordCheckbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <input type="submit" name="btn" value="Login" class="btn btn-outline-danger login_btn">
                            <button type="button" class="btn btn-outline-danger login_btn" onclick="location.href='<?= base_url('Auth_user/register') ?>'">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/main.js"></script>
</body>

</html>