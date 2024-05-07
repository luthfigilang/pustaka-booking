<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pustaka-Booking | <?= $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo/'); ?>logo-pb.png">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>user/css/styles.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>user/css/bootstrap.css">
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>datatable/datatables.css" rel="stylesheet" type="text/css">
</head>

<body style="background: #f5f5f5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Pustaka</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url(); ?>">Beranda</a></li>
                    <?php
                    if (!empty($this->session->userdata('email'))) { ?>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url('booking/riwayat'); ?>">Riwayat Pemesanan</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url('booking/info'); ?>">Info Pemesanan</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="#!">Hallo, <b>Pengunjung</b></a></li>
                    <?php } ?>
                </ul>
                <?php
                if (!empty($this->session->userdata('email'))) { ?>
                    <a href="<?= base_url('booking'); ?>">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-primary text-white ms-1 rounded-pill"><?= $this->ModelBooking->getDataWhere('temp', ['email_user' => $this->session->userdata('email')])->num_rows(); ?></span>
                        </button>
                    </a>
                    <ul class="navbar-nav my-2 my-lg-0 ms-lg-4">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['nama']; ?> </span>
                                <img class="img-profile rounded-circle" style='width: 40px; height: 40px' src="<?= base_url('assets/img/profile/') . $user['image']; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('member/myprofil'); ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('member/logout'); ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                <?php } else { ?>
                    <div class="d-flex gap-3">
                        <a class="nav-item btn btn-outline-primary nav-link" data-toggle="modal" data-target="#daftarModal" href="#">Daftar</a>
                        <a class="nav-item btn btn-primary nav-link" data-toggle="modal" data-target="#loginModal" href="#">Log in</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>