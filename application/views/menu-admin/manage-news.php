<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Berita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Berita</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <h5 class="card-header">Kelola Berita</h5>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                    onclick="submit('tambah')"><i class="fa-solid fa-circle-plus"></i> Input data</button>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Tanggal</th>
                            <th width="20%">Jenis Berita</th>
                            <th width="10%">Judul</th>
                            <th width="20%">Sub Judul</th>
                            <th width="20%">Deskripsi</th>
                            <th width="20%">Foto</th>
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
                <h4 class="modal-title">Form Data Berita</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jenis" class="col-lg-2 col-form-label">Jenis Berita</label>
                                <div class="col-lg-10">
                                    <select class="form-control" aria-label="Default select example" id="jenis"
                                        name="jenis[]">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Berita Kelurahan</option>
                                        <option value="2">Berita Bantuan</option>
                                    </select>
                                    <small class="text-danger pl-1" id="error-jenis"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Judul</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="judul" id="judul" class="form-control"
                                        placeholder="Masukkan judul">
                                    <small class="text-danger pl-1" id="error-judul"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Sub Judul</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="sub" id="sub" class="form-control"
                                        placeholder="Masukkan sub">
                                    <small class="text-danger pl-1" id="error-sub"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-lg-2 col-form-label">Deskripsi</label>
                            <div class="col-lg-10">
                                <div class="form-floating">
                                    <input type="hidden" name="id" class="form-control">
                                    <textarea name="description" id="description" class="form-control"
                                        placeholder="Masukkan deskripsi"></textarea>
                                </div>
                                <small class="text-danger pl-1" id="error-description"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="image" class="col-lg-2 col-form-label">Foto Berita</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image"
                                                onchange="previewImage(event)">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 offset-2">
                                    <small class="text-danger pl-1" id="error-image"></small>
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah" onclick="insert_data()"
                        class="btn btn-outline-primary btn-block">Tambah</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" id="btn-ubah" onclick="edit_data()"
                        class="btn btn-outline-primary btn-block">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk hapus data -->
<div class="modal fade" id="hapusNews">
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