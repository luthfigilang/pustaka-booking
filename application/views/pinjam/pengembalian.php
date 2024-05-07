<div class="container">
    <center>
        <table>
            <tr>
                <td>
                    <?= $this->session->flashdata('pesan'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="table-responsive full-width">
                        <table class="table table-bordered table-striped table-hover" id="table-datatable">
                            <tr>
                                <th>No.</th>
                                <th>No Pinjam</th>
                                <th>Tanggal pinjam</th>
                                <th>Tanggal kembali</th>
                                <th>ID User</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $no = 1;
                            foreach ($pengembalian as $p) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $p['no_pinjam']; ?></td>
                                    <td><?= $p['tgl_pinjam']; ?></td>
                                    <td><?= $p['tgl_kembali']; ?></td>
                                    <td><?= $p['id_user']; ?></td>
                                    <form action="<?= base_url('pengembalian/kembaliAct/' . $p['no_pinjam']); ?>" method="post">
                                        <td nowrap>
                                            <button type="submit" class="btn btn-sm btn-outline-info"><i class="fas fa-fw fa-cart-plus"></i> Kembali</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php $no++;
                            } ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center"><a href="<?= base_url('pengembalian'); ?>" class="btn btn-link"><i class="fas fa-fw fa-refresh"></i> Refresh</a></td>
            </tr>
        </table>
    </center>
</div>