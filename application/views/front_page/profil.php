<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola user</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-dark">Edit data profil</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-1">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" id="id" name="id">
                                    <input type="text" class="form-control" id="nama" name="nama">
                                    <small class="text-danger pl-1" id="error-nama"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email" readonly>
                                    <small class="text-danger pl-1" id="error-email"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="telepon" class="col-sm-2 col-form-label">No HP</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="telepon" name="telepon">
                                    <small class="text-danger pl-1" id="error-telepon"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="akses" class="col-sm-2 col-form-label">Posisi</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="akses" name="akses" readonly>
                                    <small class="text-danger pl-1" id="error-akses"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                    <small class="text-danger pl-1" id="error-alamat"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="image" class="col-sm-2 col-form-label">Foto</label>
                                <div class="col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image" onchange="previewImage1(event, 'imageProfil')">
                                        <label class="custom-file-label" for="image">Pilih file</label>
                                    </div>
                                    <small class="text-danger pl-1" id="error-image"></small>
                                    <div id="imageProfil"></div><br>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="ktp" class="col-sm-2 col-form-label">Foto KTP</label>
                                <div class="col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="ktp" id="ktp" onchange="previewImage1(event, 'imageKTP')">
                                        <label class="custom-file-label" for="ktp">Pilih file</label>
                                    </div>
                                    <small class="text-danger pl-1" id="error-ktp"></small>
                                    <div id="imageKTP"></div><br>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="username" name="username">
                                    <small class="text-danger pl-1" id="error-username"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="password" class="col-sm-2 col-form-label">Password Hash</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="password" name="password" readonly>
                                    <small class="text-danger pl-1" id="error-password"></small>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="password1" class="col-sm-2 col-form-label">Password Baru</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="password1" name="password1">
                                    <small class="text-danger pl-1" id="error-password1"></small>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="showPasswordCheckbox" />
                                <label class="form-check-label" for="showPasswordCheckbox">
                                    Show Password
                                </label><br><br>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-6">
                                    <button type=" button" id="btn-ubah" onclick="edit_profil()" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>