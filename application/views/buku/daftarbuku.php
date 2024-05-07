<header class="py-5" style="background-image: url(<?= base_url('assets/img/background/hero.jpg'); ?>);">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Pustaka Booking</h1>
            <p class="lead fw-normal text-white-50 mb-0">Booking buku jauh lebih mudah</p>
        </div>
    </div>
</header>
<?= $this->session->flashdata('pesan'); ?>
<section class="py-5">
    <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
        <?php foreach ($buku as $buku) { ?>
            <div class="card book">
                <!-- Product image-->
                <div style="width: 100%; display: flex; justify-content: center">
                  <img class="card-img-top" src="<?php echo base_url(); ?>assets/img/upload/<?= $buku->image; ?>" style="height: 200px; width: 200px; margin-top: 30px"/>
                </div>
                <!-- Product details-->
                <div class="card-body">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder"><?= $buku->pengarang ?></h5>
                        <!-- Product price-->
                        <?= $buku->penerbit ?>
                        <?= substr($buku->tahun_terbit, 0, 4) ?>
                    </div>
                </div>
                <!-- Product actions-->
                <div class="card-footer text-center pt-0 border-top-0 bg-transparent">
                    <p>
                        <?php
                        if ($buku->stok < 1) {
                            echo "<i class='btn btn-outline-primary fas fw fa-shopping-cart'> Booking&nbsp;&nbsp 0</i>";
                        } else {
                            echo "<a class='btn btn-outline-primary fas fw fa-shopping-cart' href='" . base_url('booking/tambahBooking/' . $buku->id) . "'> Booking</a>";
                        }
                        ?>

                        <a class="btn btn-outline-warning fas fw fa-search" href="<?= base_url('home/detailBuku/' . $buku->id); ?>"> Detail</a>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>