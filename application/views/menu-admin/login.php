<!-- <!doctype html>
<html lang="en">

<head>
    <link href="<?= base_url('assets/image/icon.png') ?>" rel="icon">
    <title> ADMIN | LOGIN </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/template-auth/css/style.css">

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">

    <style>
        body {
            background-color: #808080;
        }
    </style>

</head>

<body>
    <section class="ftco-section">
        <div class="container"><br>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(assets/image/icon.png);">
                            </div>
                            <div class="login-wrap p-4 p-md-5">
                                <div class="d-flex">
                                    <div class="w-100">
                                        <h3 class="mb-4">Selamat Datang</h3>
                                    </div>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form method="post" action="<?php echo base_url('admin'); ?>" class="signin-form">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Username</label>
                                    <input type="text" class="form-control" placeholder="Masukkan username" id="username" name="username" value="<?= set_value('username'); ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Masukkan password" id="password" name="password">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0" for="showPasswordCheckbox">Lihat password
                                            <input type="checkbox" id="showPasswordCheckbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/template-auth/js/main.js"></script>
    
</body>

</html> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url('assets/image/icon.png') ?>" rel="icon">
    <title> ADMIN | LOGIN </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@800&display=swap" rel="stylesheet">
</head>

<body onmousemove="getCursorPosition(event)">
    <div class="wrapper">
        <main>
            <section>
                <div class="face">
                    <img src="https://assets.codepen.io/9277864/PF.png" alt="Face" widht="250" height="250" />
                    <div class="eye-cover1">
                        <div id="eyes1"></div>
                    </div>

                    <div class="eye-cover2">
                        <div id="eyes2"></div>
                    </div>
                </div>
                <div class="login-container">
                    <div class="social-login">
                        <div class="logo">
                            <img src="assets/image/icon.png" alt="Gravam Company Logo" width="100" height="100" />
                            <!-- <div class="img" style="background-image: url(assets/image/icon.png);"></div> -->
                            <p>Sewa Kamera KDR</p>
                        </div>
                        <p>Halaman Login Admin</p>
                        <!-- <div class="social-grp">
                            <div class="btn"><a href="#"><img src="https://assets.codepen.io/9277864/social-media-twitter.svg" alt="" width="32" height="32" /><span>Twitter</span></a></div>
                            <div class="btn"><a href="#"><img src="https://assets.codepen.io/9277864/social-media-facebook.svg" alt="" width="32" height="32" /><span>Facebook</span></a></div>
                            <div class="btn"><a href="#"><img src="https://assets.codepen.io/9277864/social-media-google.svg" alt="" width="32" height="32" /><span>Google</span></a></div>
                        </div> -->
                    </div>
                    <div class="username-login">
                        <div class="login-h-container">
                            <h1>Login to your account</h1>
                        </div>
                        <form method="post" action="<?php echo base_url('admin'); ?>" class="signin-form">
                            <label for="username">
                                <input id="username" name="username" type="username" placeholder="" autocomplete="off">
                                <span id="span-username">username</span>
                            </label>
                            <label for="password">
                                <input id="password" name="password" type="password" placeholder="">
                                <span id="span-password">Password</span>
                            </label>
                            <input type="submit" value="Login">
                        </form>
                    </div>
                </div>
            </section>
            <div class="vector-1"></div>
            <div class="vector-2"></div>
            <div class="vector-3"></div>
        </main>
    </div>
</body>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap");

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --color-1: #ee7344;
        /* Footer Twitter link */
        --color-2: #74959a;
        /* Social login area background color */
        --color-3: #ffc85c;
        /* Social login buttons */
        --color-4: #ea5455;
        /* Login with username button */
    }

    body {
        font-family: Montserrat, sans-serif;
        height: 100vh;
        font-size: 17px;
    }

    .wrapper {
        max-width: 960px;
        min-width: 220px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    main {
        padding: 10px 20px;
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 999;
        background-color: #232323;
        color: white;
        text-align: center;
        padding: 6px;
    }

    footer a {
        color: var(--color-1);
        text-decoration: none;
    }

    section {
        margin-top: 20px;
        margin-bottom: 160px;
    }

    .face {
        text-align: center;
        position: relative;
    }

    .eye-cover1 {
        position: absolute;
        width: 30px;
        height: 12px;
        top: 40%;
        left: 46%;
        border-radius: 30%;
    }

    .eye-cover2 {
        position: absolute;
        width: 26px;
        height: 13px;
        top: 40%;
        left: 52%;
        border-radius: 30%;
    }

    #eyes1 {
        width: 10px;
        height: 10px;
        background-color: #fff;
        position: absolute;
        border-radius: 50%;
        border: 4px solid #333;
        overflow: hidden;
        top: 25%;
        left: 35%;
    }

    #eyes2 {
        width: 10px;
        height: 10px;
        background-color: #fff;
        position: absolute;
        border-radius: 50%;
        border: 4px solid #333;
        overflow: hidden;
        top: 28%;
        left: 32%;
    }

    .login-container {
        display: flex;
        border-radius: 3px;
        box-shadow: 6px 0 15px rgba(0, 0, 0, 0.4);
    }

    .social-login {
        background-color: var(--color-2);
        color: #fff;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        gap: 30px;
        flex: 1;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .social-login a {
        text-decoration: none;
    }

    .logo {
        display: flex;
        align-items: center;
        font-size: 32px;
        font-weight: bold;
        font-family: "Unbounded", cursive;
    }

    .logo p {
        margin-top: 21px;
    }

    .btn {
        margin-bottom: 15px;
        border: 1px solid black;
        border-radius: 6px;
        box-shadow: 0.3rem 0.3rem #111827;
        background-color: var(--color-3);
        transition-duration: 0.2s;
    }

    .btn:hover {
        transform: scale(1.01);
        filter: brightness(90%);
    }

    .btn a {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 17px;
        padding: 8px 21px;
        color: #111827;
        font-weight: bold;
    }

    .username-login {
        flex: 2;
        padding: 40px;
    }

    .username-login a {
        color: blue;
        text-decoration: none;
    }

    .username-login a:hover {
        border-bottom: 1px solid blue;
    }

    .login-h-container {
        margin-bottom: 20px;
    }

    h1 {
        margin-bottom: 5px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    input:focus {
        outline: 1px solid #ffc85c;
        transform: scale(1.005);
    }

    input[type="username"],
    input[type="password"] {
        line-height: 2.6;
        padding: 0 10px;
        font-size: 17px;
        width: 100%;
    }

    input[type="submit"] {
        background-color: var(--color-4);
        padding: 10px 120px;
        color: #fff;
        font-size: 20px;
        border: 1px solid transparent;
        border-radius: 3px;
        margin-block: 30px;
        box-shadow: 0.3rem 0.3rem #111827;
        cursor: pointer;
        transition-duration: 0.2s;
    }

    input[type="submit"]:hover {
        transform: scale(1.007);
        filter: brightness(90%);
    }

    input[type="checkbox"] {
        width: 17px;
        height: 17px;
    }

    label {
        position: relative;
    }

    label span {
        transition-duration: 0.2s;
        font-size: 18px;
        color: #5a5959;
        font-weight: 600;
        position: absolute;
        left: 6px;
        top: 11px;
        padding: 4px 8px;
    }

    label:focus-within span,
    .focus-span {
        transform: translate(0.27rem, -94%) scale(0.8);
        background-color: #fff;
    }

    .recovery {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
    }

    .recovery div {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .recovery a {
        margin-left: 10px;
        white-space: nowrap;
    }

    .vector-1 {
        background-image: url("https://assets.codepen.io/9277864/8.png");
        background-size: cover;
        width: 70px;
        height: 70px;
        position: absolute;
        top: 15%;
        left: 15%;
        z-index: -1;
        opacity: 0.2;
        transform: rotate(45deg);
    }

    .vector-2 {
        background-image: url("https://assets.codepen.io/9277864/6.png");
        background-size: cover;
        width: 70px;
        height: 70px;
        position: absolute;
        top: 12%;
        left: 72%;
        z-index: -1;
        opacity: 0.2;
        transform: rotate(-45deg);
    }

    .vector-3 {
        background-image: url("https://assets.codepen.io/9277864/1.png");
        background-size: cover;
        width: 70px;
        height: 70px;
        position: absolute;
        top: 85%;
        left: 42%;
        z-index: -1;
        opacity: 0.2;
        transform: rotate(-25deg);
    }

    @media only screen and (max-width: 890px) {
        .eye-cover1 {
            left: 45%;
        }

        .eye-cover2 {
            left: 52.5%;
        }
    }

    @media only screen and (max-width: 860px) {
        input[type="submit"] {
            padding-inline: 0;
        }
    }

    @media only screen and (max-width: 720px) {
        .login-container {
            flex-direction: column;
        }

        .eye-cover1 {
            left: 41.2%;
        }

        .eye-cover2 {
            left: 54.5%;
        }

        .vector-3 {
            top: 89%;
        }
    }

    @media only screen and (max-width: 420px) {
        main {
            padding: 0;
        }

        .social-login {
            padding: 20px;
        }

        .logo {
            font-size: 28px;
        }

        .logo img {
            width: 92px;
            height: 92px;
        }

        .username-login {
            padding: 20px;
        }

        .btn a {
            padding: 8px 12px;
        }

        .eye-cover1 {
            left: 41%;
        }

        .eye-cover2 {
            left: 56%;
        }
    }

    .codepen-footer {
        font-family: "Patrick Hand", cursive;
        font-size: 17px;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 99;
        background-color: #232323;
        color: white;
        text-align: center;
        height: 38px;
        font-size: 21px;
        display: flex;
        justify-content: space-between;
        padding: 6px 20px;
    }

    .codepen-footer a {
        color: #ee7344;
        text-decoration: none;
    }
</style>
<script>
    function getCursorPosition(event) {
        const x = (event.clientX * 100) / window.innerWidth + "%";
        const y = (event.clientY * 100) / window.innerHeight + "%";

        const eyes1 = document.getElementById("eyes1");
        const eyes2 = document.getElementById("eyes2");

        eyes1.style.left = x;
        eyes1.style.top = y;
        eyes1.style.transform = `translate(-${x}, -${y})`;

        eyes2.style.left = x;
        eyes2.style.top = y;
        eyes2.style.transform = `translate(-${x}, -${y})`;
    }

    const username = document.getElementById("username");
    const usernameSpan = document.getElementById("span-username");
    const password = document.getElementById("password");
    const passwordSpan = document.getElementById("span-password");

    username.addEventListener("input", () => {
        if (username.value) {
            usernameSpan.classList.add("focus-span");
        } else {
            usernameSpan.classList.remove("focus-span");
        }
    });

    password.addEventListener("input", () => {
        if (password.value) {
            passwordSpan.classList.add("focus-span");
        } else {
            passwordSpan.classList.remove("focus-span");
        }
    });
</script>

</html>