<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Selamat Datang
                        <?= $user['name']; ?> -
                        <?= $user['akses']; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p>Pelanggan Belum Diverifikasi</p>
                            <h3>
                                <?= $pelanggan_daftar; ?> Pelanggan
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                        <a href="<?= base_url('manage-pelanggan-daftar') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p>Pelanggan Aktif</p>
                            <h3>
                                <?= $pelanggan_aktif; ?> Pelanggan
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                        <a href="<?= base_url('manage-pelanggan-aktif') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <p>Mitra Belum Diverifikasi</p>
                            <h3>
                                <?= $mitra_daftar; ?> Mitra
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                        <a href="<?= base_url('manage-mitra-daftar') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Mitra Aktif</p>
                            <h3>
                                <?= $mitra_aktif; ?> Mitra
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                        <a href="<?= base_url('manage-mitra-aktif') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="mitraChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="produkChart"></canvas>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>