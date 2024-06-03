<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Verifikasi Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Verifikasi Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <h5 class="card-header">Verifikasi Produk</h5>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Filter Status Verifikasi</label>
                            <select class="form-control" id="filterVerifikasi">
                                <option value="">Semua</option>
                                <option value="Proses Verifikasi">Proses Verifikasi</option>
                                <option value="Terverifikasi">Terverifikasi</option>
                                <option value="Ditolak Verifikasi">Ditolak Verifikasi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Mitra</th>
                            <th width="20%">Nama Produk</th>
                            <th width="10%">Status</th>
                            <th width="20%">Foto</th>
                            <th width="20%">Aksi</th>
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
                            <input type="hidden" name="id" class="form-control" value="">
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
                            <input type="text" name="type" id="type" class="form-control" disabled>
                            <small class="text-danger pl-3" id="error-type"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" name="stok" id="stok" class="form-control" disabled>
                            <small class="text-danger pl-3" id="error-stok"></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label for="image" class="col-lg-1">Foto</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image" onchange="previewImage(event)" disabled>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control" disabled>
                            <small class="text-danger pl-3" id="error-harga"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="" id="deskripsi" name="deskripsi" style="height: 100px" disabled></textarea>
                    </div>
                    <small class="text-danger pl-3" id="error-deskripsi"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Verifikasi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="verifikasi" id="verifikasi" value="1" checked>
                                <label class="form-check-label" for="verifikasi">
                                    Verifikasi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="verifikasi" id="tolakVerifikasi" value="2">
                                <label class="form-check-label" for="tolakVerifikasi">
                                    Tolak Verifikasi
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Keterangan(opsional)</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="" id="keterangan" name="keterangan" style="height: 100px"></textarea>
                            </div>
                            <small class="text-danger pl-3" id="error-keterangan"></small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-ubah" onclick="edit_data()" class="btn btn-outline-primary btn-block">Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk hapus data -->
<div class="modal fade" id="hapusProduct">
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
<!-- Modal untuk memperbesar gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>