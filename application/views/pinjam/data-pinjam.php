<div class="container">
    <center>
        <table>
            <tr>
                <td>
                    <div class="table-responsive full-width">
                        <table class="table table-bordered table-striped table-hover" id="table-datatable">
                            <tr>
                                <th>No Pinjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>ID User</th>
                                <th>ID Buku</th>
                                <th>Tanggal Kembali</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>Total Denda</th>
                            </tr>
                            <?php
                            foreach ($pinjam as $p) {
                            ?>
                                <tr>
                                    <td><?= $p['no_pinjam']; ?></td>
                                    <td><?= $p['tgl_pinjam']; ?></td>
                                    <td><?= $p['id_user']; ?></td>
                                    <td><?= $p['id_buku']; ?></td>
                                    <td><?= $p['tgl_kembali']; ?></td>
                                    <td><?= $p['tgl_pengembalian']; ?></td>
                                    <td><?= $p['denda']; ?></td>

                                    <?php if ($p['status'] == "Pinjam") {
                                        $status = "warning";
                                    } else {
                                        $status = "secondary";
                                    } ?>
                                    <td><i class="btn btn-outline-<?= $status; ?> btn-sm"><?= $p['status']; ?></i></td>
                                    <td><?= $p['total_denda']; ?></td>
                                </tr>
                            <?php
                            } ?>
                        </table>
                    </div>
                </td>
            </tr>

        </table>
    </center>
</div>