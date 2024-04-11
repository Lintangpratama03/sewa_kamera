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
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?= base_url('manage-kembali') ?>" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-success" id="confirmButton">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailPesan">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Pemesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="judul1">Detail Penyewa</label>
                        <div class="row mb-1">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" id="id" name="id">
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                                <small class="text-danger pl-1" id="error-nama"></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="image" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-6">
                                <div id="imagePreview1"></div><br>
                            </div>
                        </div>
                        <label for="judul1">Detail Pesanan</label>
                        <table id="detailTable" class="table table-hover table-bordered" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Tgl Booking</th>
                                    <th width="10%">Nama Produk</th>
                                    <th width="10%">Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailBayar">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Bayar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="judul1">Detail Penyewa</label>
                        <div class="row mb-1">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" id="id" name="id">
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                                <small class="text-danger pl-1" id="error-nama"></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="image" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-6">
                                <div id="imagePreview"></div><br>
                            </div>
                        </div>
                        <label for="judul1">Detail Bayar</label>
                        <table id="detailTable" class="table table-hover table-bordered" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Tgl Booking</th>
                                    <th width="10%">Nama Produk</th>
                                    <th width="10%">Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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