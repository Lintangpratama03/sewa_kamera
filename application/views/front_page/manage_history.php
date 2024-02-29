<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Data History Administrasi</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <h6>Filter range tanggal</h6>
                    </div>
                </div>
                <form method="POST" id="aksidata">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#reservationdate1" id="date1" name="date1" />
                                <div class="input-group-append" data-target="#reservationdate1"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <h3> - </h3>
                        <div class="col-lg-2">
                            <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#reservationdate2" id="date2" name="date2" />
                                <div class="input-group-append" data-target="#reservationdate2"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-success" onclick="get_data_filter()">Cari data</button>
                        </div>
                    </div>
                </form>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="15%">Nama Surat</th>
                            <th width="20%">Tanggal Pengajuan</th>
                            <th width="20%">Tanggal Selesai</th>
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

<!-- modal untuk detail arsip/history-->
<div class="modal fade" id="detailArsip">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Arsip Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-3 col-form-label">Nama</label>
                                <div class="col-lg-9">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="nama" id="nama" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="letter" class="col-lg-3 col-form-label">Nama Surat</label>
                                <div class="col-lg-9">
                                    <input type="text" name="letter" id="letter" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date" class="col-lg-3 col-form-label">Tanggal Pengajuan</label>
                                <div class="col-lg-9">
                                    <input type="text" name="date" id="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date2" class="col-lg-3 col-form-label">Tanggal Selesai</label>
                                <div class="col-lg-9">
                                    <input type="text" name="date2" id="date2" class="form-control" readonly>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="date" class="col-lg-3 col-form-label">Arsip surat</label>
                                <div class="col-lg-9">
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-balas" class="btn btn-outline-primary btn-block"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>