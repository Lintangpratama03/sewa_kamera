<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Transaksi Pemesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <h5 class="card-header">Kelola Transaksi</h5>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="status">Filter Status</label>
                            <select class="form-control status" id="status">
                                <option value="">Semua Status</option>
                                <option>Belum dicek</option>
                                <option>Proses Bayar</option>
                                <option>Sudah Bayar</option>
                                <option>Sudah Diambil</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tanggal">Filter Tanggal Booking</label>
                            <div class="input-group date" id="tanggalWrapper" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="tanggal" name="tanggal" data-target="#tanggalWrapper" placeholder="Pilih Tanggal" readonly>
                                <div class="input-group-append" data-target="#tanggalWrapper" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-block btn-primary" onclick="filterData()"><i class="fa-solid fa-search"></i>Cari</button>
                        </div>
                    </div>
                </div>

                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Tgl Booking</th>
                            <th width="10%">Nama Pelanggan</th>
                            <th width="10%">Keterangan</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
                                <div id="imagePreview"></div><br>
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
                    <div class="modal-footer d-flex justify-content-start">
                        <div class="col-lg-2">
                            <button type="button" id="btn-tolak" onclick="tolak_data()" class="btn btn-outline-danger btn-block">Tolak</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" id="btn-ubah" onclick="terima_data()" class="btn btn-outline-success btn-block">Konfirmasi</button>
                        </div>
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
                    <div class="modal-footer d-flex justify-content-start">
                        <div class="col-lg-2">
                            <button type="button" id="btn-tolak" onclick="tolak_data()" class="btn btn-outline-danger btn-block">Tolak</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" id="btn-ubah" onclick="terima_data()" class="btn btn-outline-success btn-block">Konfirmasi</button>
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
</script>