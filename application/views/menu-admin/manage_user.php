<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Pelanggan Baru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Pelanggan Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <h5 class="card-header">Kelola Pelanggan Baru</h5>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="submit('tambah')"><i class="fa-solid fa-circle-plus"></i> Input data</button>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Nama</th>
                            <th width="15%">Email</th>
                            <th width="25%">Address</th>
                            <th width="10%">Posisi</th>
                            <th width="10%">Foto</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- modal untuk edit data -->
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Nama</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama">
                                    <small class="text-danger pl-1" id="error-nama"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-lg-2 col-form-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Masukkan Email">
                                    <small class="text-danger pl-1" id="error-email"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="telepon" class="col-lg-2 col-form-label">No
                                    HP</label>
                                <div class="col-lg-10">
                                    <input type="number" name="telepon" id="telepon" class="form-control" placeholder="Masukkan No HP">
                                    <small class="text-danger pl-1" id="error-telepon"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="alamat" class="col-lg-2 col-form-label">Alamat</label>
                                <div class="col-lg-10">
                                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat">
                                    <small class="text-danger pl-1" id="error-alamat"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="image" class="col-lg-2 col-form-label">Foto profil</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image" onchange="previewImage(event)">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 offset-2">
                                    <small class="text-danger pl-1" id="error-image"></small>
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="card" class="col-lg-2 col-form-label">KTP</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="card" id="card" onchange="previewImage1(event)">
                                            <label class="custom-file-label" for="card">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 offset-2">
                                    <small class="text-danger pl-1" id="error-card"></small>
                                    <div id="imagePreviewCard"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="username" class="col-lg-2 col-form-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username">
                                    <small class="text-danger pl-1" id="error-username"></small><br>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label for="password" class="col-lg-2 col-form-label" id="passwordLabel">Password</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password">
                                        <small class="text-danger pl-1" id="error-password"></small>
                                    </div>

                                    <label for="password1" class="col-lg-2 col-form-label" id="passwordLabel1">Ulangi</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="password1" id="password1" class="form-control" placeholder="Ulangi Password">
                                        <small class="text-danger pl-1" id="error-password1"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="showPasswordCheckbox" />
                                <label class="form-check-label" for="showPasswordCheckbox">
                                    Show
                                    Password
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-6">
                    <button type="button" id="btn-tambah" onclick="insert_data()" class="btn btn-outline-primary btn-block">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- konfirmasi -->
<div class="modal fade" id="konfirmasiModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Nama</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" readonly>
                                    <small class="text-danger pl-1" id="error-nama"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-lg-2 col-form-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Masukkan Email" readonly>
                                    <small class="text-danger pl-1" id="error-email"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="telepon" class="col-lg-2 col-form-label">No
                                    HP</label>
                                <div class="col-lg-10">
                                    <input type="number" name="telepon" id="telepon" class="form-control" placeholder="Masukkan No HP" readonly>
                                    <small class="text-danger pl-1" id="error-telepon"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="alamat" class="col-lg-2 col-form-label">Alamat</label>
                                <div class="col-lg-10">
                                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat" readonly>
                                    <small class="text-danger pl-1" id="error-alamat"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="image" class="col-lg-2 col-form-label">Foto profil</label>
                                <!-- <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image" onchange="previewImage(event)">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-lg-6 offset-2">
                                    <small class="text-danger pl-1" id="error-image"></small>
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="card" class="col-lg-2 col-form-label">KTP</label>
                                <!-- <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="card" id="card" onchange="previewImage1(event)">
                                            <label class="custom-file-label" for="card">Pilih file</label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-lg-6 offset-2">
                                    <small class="text-danger pl-1" id="error-card"></small>
                                    <div id="imagePreview1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="username" class="col-lg-2 col-form-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" readonly>
                                    <small class="text-danger pl-1" id="error-username"></small><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tolak" onclick="tolak_data()" class="btn btn-outline-danger btn-block">Tolak</button>
                </div>
                <div class="col-lg-3">
                    <button type="button" id="btn-konfirmasi" onclick="konfirmasi_data()" class="btn btn-outline-success btn-block">Konfirmasi</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- modal untuk hapus data -->
<div class="modal fade" id="hapusAdmin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Klik hapus jika anda ingin menghapus data ini</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-warning" type="button" id="btn-hapus" data-dismiss="modal">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>