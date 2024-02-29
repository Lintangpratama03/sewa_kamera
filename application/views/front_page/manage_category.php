<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Kategori Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Kategori Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Data Kategori Produk</h5>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                    onclick="submit('tambah')"><i class="fa-solid fa-circle-plus"></i> Input data</button>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Kategori</th>
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

<!-- modal untuk insert dan edit data -->
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Data Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Nama Kategori</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        placeholder="Masukkan nama kategori">
                                    <small class="text-danger pl-1" id="error-nama"></small>
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
<div class="modal fade" id="hapusKategori">
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