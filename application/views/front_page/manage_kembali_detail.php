<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Kamera Yang Disewa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <h5 class="card-header">Detail No Transaksi <?= $id; ?></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="label">-- Detail Penyewa --</label>
                        <div class="row mb-1">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" id="id" name="id">
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                                <small class="text-danger pl-1" id="error-nama"></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="telepon" class="col-sm-2 col-form-label">No HP</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="telepon" name="telepon" readonly>
                                <small class="text-danger pl-1" id="error-telepon"></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                                <small class="text-danger pl-1" id="error-alamat"></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="image" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-8">
                                <div id="imageProfil"></div><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="label">-- Detail Kamera Yang di Sewa --</label>
                        <br>
                        <table id="example" class="table table-hover table-bordered" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Nama Kamera</th>
                                    <th width="10%">Jumlah Pinjam</th>
                                    <th width="10%">Foto</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?= base_url('manage-kembali') ?>" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-success" id="confirmButton">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- detail produk -->
        <div class="modal fade" id="exampleModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Form Data Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="hidden" name="id_d" class="form-control" value="">
                                    <input type="text" name="judul" id="judul" class="form-control" readonly>
                                    <small class="text-danger pl-3" id="error-judul"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width: 100%;">
                                    <label>Kategori</label>
                                    <select id="kategori" name="kategori[]" class="form-control" disabled>
                                        <?php foreach ($select as $row) : ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger pl-3" id="error-kategori"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" name="type" id="type" class="form-control" readonly>
                                    <small class="text-danger pl-3" id="error-type"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Pinjam</label>
                                    <input type="text" name="jml" id="jml" class="form-control" readonly>
                                    <small class="text-danger pl-3" id="error-jml"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="image" class="col-lg-1">Foto</label>
                                        <div class="col-lg-4 offset-2">
                                            <small class="text-danger pl-1" id="error-image"></small>
                                            <div id="imagePreview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="harga" id="harga" class="form-control" readonly>
                                    <small class="text-danger pl-3" id="error-harga"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="" id="keterangan" name="keterangan" style="height: 100px"></textarea>
                            </div>
                            <small class="text-danger pl-3" id="error-keterangan"></small>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <div class="col-lg-2">
                            <button type="button" id="btn-tambah" onclick="tolak_data()" class="btn btn-outline-danger btn-block">Tidak Kembali</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" id="btn-ubah" onclick="terima_data()" class="btn btn-outline-success btn-block">Konfirmasi Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
    var _id = <?php echo $id; ?>;
</script>