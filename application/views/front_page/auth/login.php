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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body style="background: url('https://i.postimg.cc/vmvc7VFy/3deddafc4235818cfc607496c90be1cc.jpg') no-repeat center center fixed; background-size: cover;">
    <canvas class="background"></canvas>
    <div class="login__page">
        <div class="forms">
            <form class="signin" action="<?php echo base_url('mitra'); ?>" method="post">
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <button type="submit" name="btn" class="btn__login">Login</button>
                <p class="message">Not registered? <a id="register">Create an account</a></p>
            </form>

            <form class="signup disabled" action="<?php echo base_url('registrasi'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateRegistrationForm()">
                <input type="text" placeholder="Nama Lengkap" name="nama" id="nama" value="<?= set_value('nama'); ?>" />
                <input type="text" placeholder="Telepon" name="telepon" id="telepon" value="<?= set_value('telepon'); ?>" />
                <input type="text" name="username" id="username" value="<?= set_value('username'); ?>" placeholder="Username" />
                <input type="email" name="email" id="email" value="<?= set_value('email'); ?>" placeholder="Email" autocomplete="off" />
                <input type="password" name="password" id="password" placeholder="Password" />
                <input type="password" name="password1" id="password1" placeholder="Repeat password" />
                <label for="image" class="file-upload" style="color: white;">
                    <i class="fas fa-file-upload"></i>KTP
                </label>
                <input type="file" name="image" id="image" accept="image/*" />
                <label for="ktp" class="file-upload" style="color: white;">
                    <i class="fas fa-file-upload"></i>FOTO USAHA
                </label>
                <input type="file" name="ktp" id="ktp" accept="image/*" />
                <button type="submit" class="btn__login">Register</button>
                <p class="message">Already registered? <a id="login">Sign In</a></p>
            </form>

        </div>
    </div>

    <script src="../js/login.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Particles.init({
                selector: '.background',
                maxParticles: 200,
                connectParticles: true,
                color: '#ffffff',
                responsive: [{
                        breakpoint: 768,
                        options: {
                            maxParticles: 100
                        }
                    },
                    {
                        breakpoint: 425,
                        options: {
                            maxParticles: 50
                        }
                    },
                    {
                        breakpoint: 320,
                        options: {
                            maxParticles: 30
                        }
                    }
                ]
            });
        });
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>
    <script>
        <?php if (isset($errors) && !empty($errors)) : ?>
            <?php foreach ($errors as $field => $error) : ?>
                <?php if (!empty($error)) : ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '<?= $error ?>',
                    });
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </script>
</body>
<style>
    * {
        padding: 0;
        margin: 0;
    }

    body {
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: Arial, Helvetica, sans-serif;
    }

    .login__page {
        width: 360px;
        background: #2525259a;
        margin: 10rem auto 0;
    }

    .forms {
        width: 100%;
        padding: 50px;
        box-sizing: border-box;
        margin: 0 0 0 10px;
    }

    .signin,
    .signup button {
        display: block;
    }

    .disabled {
        display: none;
        transition: 1s;
    }


    .signin input,
    .signup input {
        width: 250px;
        height: 40px;
        margin-bottom: 10px;
        border: none;
        color: #fff;
        background: #b6b6b68c;
        font-size: 14pt;
        padding-left: 35px;
        padding-right: 10px;
        box-sizing: border-box;
        border-radius: 20px;
    }

    .signin input[type="password"],
    .signup input[type="password"] {
        padding-right: 30px;
    }

    .signin input:focus,
    .signup input:focus {
        border: 2px solid #b4b4b4;
        background: rgba(255, 255, 255, 0.226);
    }

    .signin input:hover,
    .signup input:hover {
        background: rgba(255, 255, 255, 0.226);
        transition: background 0.3s;
    }

    .signin,
    .signup {
        position: relative;
    }

    /*ICONS*/

    .fa-user,
    .fa-key,
    .fa-eye,
    .fa-redo,
    .fa-envelope,
    .fa-eye-slash {
        position: absolute;
        font-size: 16pt;
        color: #eee;
    }

    .signin .fa-user {
        left: 9px;
        top: 58px;
    }

    .signup div {
        position: absolute;
    }

    .signup .fa-user {
        left: 9px;
        top: 110px;
    }


    .signin .fa-eye,
    .signin .fa-eye-slash {
        right: 15px;
        top: 60px;
        cursor: pointer;
    }

    .signin .fa-key {
        left: 9px;
        top: 60px;
    }

    .signup .fa-envelope {
        left: 9px;
        top: 160px;
    }

    .signup .fa-key {
        left: 9px;
        top: 210px;
    }

    .signup .fa-eye,
    .signup .fa-eye-slash {
        right: 15px;
        top: 210px;
        cursor: pointer;
    }


    .signup .fa-redo {
        left: 9px;
        font-size: 14pt;
        top: 260px;
    }


    .btn__login {
        width: 150px;
        height: 40px;
        border: none;
        font-size: 16pt;
        margin: 0 50px;
        color: #fff;
        margin-bottom: 10px;
        background: #3b3b3b;
        border-radius: 20px;
        cursor: pointer;
    }

    .signin .btn__login:hover,
    .signin .btn__login:active,
    .signin .btn__login:focus {
        background: rgba(54, 134, 255, 0.699);
        transition: 0.3s;
    }

    .signup .btn__login:hover,
    .signup .btn__login:active,
    .signup .btn__login:focus {
        background: rgba(54, 255, 71, 0.699);
        transition: 0.3s;
    }

    /*END ICONS*/

    .message {
        color: rgba(255, 255, 255, 0.493);
    }

    .message a {
        text-decoration: none;
        color: #ffffff;
        cursor: pointer;
    }

    .message a:hover {
        color: #b4b4b4;
        transition: 0.3s;
    }

    .background {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        z-index: -1;
    }

    .signup .fa-file-upload {
        left: 9px;
        top: 310px;
        font-size: 14pt;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/js/custom.js') ?>"></script>
<script>
    <?php if ($this->session->flashdata('errors')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<?= $this->session->flashdata('errors') ?>',
        });
    <?php endif; ?>
</script>
<script>
    // Fungsi untuk memvalidasi form registrasi
    function validateRegistrationForm() {
        const nama = document.getElementById('nama').value.trim();
        const telepon = document.getElementById('telepon').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const password1 = document.getElementById('password1').value.trim();
        const image = document.getElementById('image').value.trim();
        const ktp = document.getElementById('ktp').value.trim();

        if (!nama) {
            showError('Nama harus diisi.');
            return false;
        }
        if (!email || !isValidEmail(email)) {
            showError('Email harus valid dan diisi.');
            return false;
        }
        if (!telepon || isNaN(telepon)) {
            showError('Nomor HP harus diisi dengan angka.');
            return false;
        }
        if (!username) {
            showError('Username harus diisi.');
            return false;
        }


        if (!password || password.length < 8) {
            showError('Password harus diisi dan minimal 8 karakter.');
            return false;
        }

        if (!password1 || password1 !== password) {
            showError('Konfirmasi password harus sama dengan password.');
            return false;
        }

        if (!image) {
            showError('File image harus diisi.');
            return false;
        }
        if (!ktp) {
            showError('File KTP harus diisi.');
            return false;
        }

        return true;
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        });
    }

    const getElements = () => [...document.querySelectorAll('#register, #login')];

    const createEventClick = element =>
        element.addEventListener('click', toggleElements);

    const toggleElements = () => {
        document.querySelector('.signin').classList.toggle('disabled');
        document.querySelector('.signup').classList.toggle('disabled');
    };

    getElements()
        .map(createEventClick);
    <?php if ($this->session->flashdata('message')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= $this->session->flashdata('message') ?>',
        });
    <?php endif; ?>
</script>

</html>