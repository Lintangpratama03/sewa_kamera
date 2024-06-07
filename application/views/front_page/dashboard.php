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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p>Kamera Ready</p>
                            <h3>
                                <?= $produk_ready; ?> Kamera
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p>Kamera Yang Dipinjam</p>
                            <h3>
                                <?= $produk_pinjam; ?> Kamera
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <p>Total Jenis Kamera</p>
                            <h3>
                                <?= $total_produk; ?> Kamera
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Total Kamera Tidak Kembali</p>
                            <h3>
                                <?= $produk_hilang; ?> Kamera
                            </h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Data Pemasukan</h5>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong>Grafik Pemasukan</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">

                                        <h5 class="description-header">Rp. <?= $pendapatan_bulan_kemarin; ?></h5>
                                        <span class="description-text">BULAN KEMARIN</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">

                                        <h5 class="description-header">Rp. <?= $pendapatan_bulan_ini; ?></h5>
                                        <span class="description-text">BULAN INI</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">

                                        <h5 class="description-header">Rp. <?= $pendapatan_tahun_ini; ?></h5>
                                        <span class="description-text">TAHUN INI</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">

                                        <h5 class="description-header">Rp. <?= $pendapatan_all; ?></h5>
                                        <span class="description-text">ALL TIME</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Grafik Penyewaan Perbulan</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span>Total Seluruh Penyewaan: <?= $jumlah_sewa; ?></span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Data Penyewaan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">5 Kamera Yang Sering Dipinjam</h3>
                                <a href="<?= site_url('manage-history') ?>">Selengkapnya..</a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="position-relative mb-4">
                                <table id="example" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Nama Produk</th>
                                            <th width="20%">Nama Kategori</th>
                                            <th width="20%">Total Pinjam</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
    var visitorsChartData = <?php echo json_encode(array_values($chartData)); ?>;
    var visitorsChartLabels = <?php echo json_encode(array_keys($chartData)); ?>;
    var salesChartData = <?php echo json_encode(array_values($chartPendapatan)); ?>;
    var salesChartLabels = <?php echo json_encode(array_keys($chartPendapatan)); ?>;
    var maxValue = Math.max(...visitorsChartData); // Mendapatkan nilai maksimum dari data
    var suggestedMax = Math.ceil(maxValue / 5) * 5 + 5;
</script>