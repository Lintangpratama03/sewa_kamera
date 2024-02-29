<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Ulasan Pelanggan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Ulasan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <h5 class="card-header">Kelola Ulasan</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Filter status</label>
                            <select class="form-control status" style="width: 100%;">
                                <option value="">Semua status</option>
                                <option>Belum dicek</option>
                                <option>Sudah dibaca</option>
                                <option>Sudah dibalas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Nama Produk</th>
                            <th width="10%">Nama Pelanggan</th>
                            <th width="10%">Rating</th>
                            <th width="25%">Ulasan</th>
                            <th width="12%">Status</th>
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

<!-- modal untuk cek Ulasan -->
<div class="modal fade" id="cekUlasan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Tandai sudah dibaca?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-warning" type="button" id="btn-success" data-dismiss="modal">Iya</button>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk balas Ulasan -->
<div class="modal fade" id="balasUlasan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Ulasan</h4>
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
                                    <input type="text" name="nama" id="nama" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="message" class="col-lg-2 col-form-label">Ulasan</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" id="message" name="message" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <label for="reply" class="col-lg-2 col-form-label">Balasan</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="4" id="reply" name="reply"></textarea>
                                    <small class="text-danger pl-1" id="error-reply"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-balas" onclick="reply_message()" class="btn btn-outline-primary btn-block">Balas</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- modal untuk detail Ulasan jika belum ada balasan-->
<div class="modal fade" id="detailUlasan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Ulasan</h4>
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
                                    <input type="text" name="nama" id="nama" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-lg-2 col-form-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" id="email" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="rating" class="col-lg-2 col-form-label">Rating</label>
                                <div class="col-lg-10">
                                    <input type="text" name="rating" id="rating" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="message" class="col-lg-2 col-form-label">Ulasan</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" id="message" name="message" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date" class="col-lg-2 col-form-label">Ulasan dikirim</label>
                                <div class="col-lg-10">
                                    <input type="text" name="date" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-balas" class="btn btn-outline-primary btn-block" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- modal untuk detail Ulasan jika sudah ada balasan-->
<div class="modal fade" id="detailUlasan1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Ulasan</h4>
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
                                    <input type="text" name="nama" id="nama" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="email" class="col-lg-2 col-form-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" id="email" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="rating" class="col-lg-2 col-form-label">Rating</label>
                                <div class="col-lg-10">
                                    <input type="text" name="rating" id="rating" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="message" class="col-lg-2 col-form-label">Ulasan</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" id="message" name="message" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date" class="col-lg-2 col-form-label">Ulasan dikirim</label>
                                <div class="col-lg-10">
                                    <input type="text" name="date" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <label for="reply" class="col-lg-2 col-form-label">Balasan</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="4" id="reply" name="reply" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="admin" class="col-lg-2 col-form-label">Dibalas oleh</label>
                                <div class="col-lg-10">
                                    <input type="text" name="admin" id="admin" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date2" class="col-lg-2 col-form-label">Balasan dikirim</label>
                                <div class="col-lg-10">
                                    <input type="text" name="date2" id="date2" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-balas" class="btn btn-outline-primary btn-block" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>