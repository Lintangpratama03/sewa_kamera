<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="modal fade" id="logoutModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin untuk keluar?</h5>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="<?php echo base_url('logout') ?>">Yakin</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.navbar -->

        <!-- SIDEBAR -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="brand-link">
                <div class="image">
                    <img src="<?= base_url() ?>assets/image/logo.png" style="width:100%" alt="Brawijaya_logo">
                </div>
            </div>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('assets/image/user/') . $user['image']; ?>"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?= $user['name']; ?>
                        </a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?php foreach ($get_menu as $menu): ?>
                            <?php if ($menu->type == 1): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url($menu->link) ?>" class="nav-link">
                                        <i class="nav-icon <?= $menu->icon ?>"></i>
                                        <p>
                                            <?= $menu->name ?>
                                        </p>
                                    </a>
                                </li>
                            <?php elseif ($menu->type == 2): ?>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon <?= $menu->icon ?>"></i>
                                        <p>
                                            <?= $menu->name ?>
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php foreach ($get_dropdown as $dropdown): ?>
                                            <?php if ($dropdown->id_parent == $menu->id_parent): ?>
                                                <?php foreach ($get_child as $child): ?>
                                                    <?php if ($dropdown->id_parent == $child->id_parent): ?>
                                                        <li class="nav-item">
                                                            <a href="<?= base_url($child->link) ?>" class="nav-link">
                                                                <i class="fa-solid fa-circle-chevron-right fa-2xs"></i>
                                                                <p>
                                                                    <?= $child->name ?>
                                                                </p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </aside>