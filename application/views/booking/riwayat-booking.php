<div class="container my-5">
	<center>
		<table>
            <tr>
                <td nowrap>Terima Kasih <b><?= $user['nama']; ?></b>
                </td>
            </tr>
            <tr>
                <td>Riwayat Buku Yang telah Anda Pinjam Adalah Sebagai berikut:</td>
            </tr>
			<tr>
				<td>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-datatable">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali </th>
                            <th scope="col">Tanggal Dikembalikan</th>
                            <th scope="col">Total Denda</th>
                        </tr>
                        <?php
                        $a = 1;
                        foreach ($riwayat as $r) { ?>
                            <tr>
                                <th scope="row"><?= $a++; ?></th>
                                <td><?= $r['judul_buku']; ?></td>
                                <td><?= $r['tgl_pinjam']; ?></td>
                                <td><?= $r['tgl_kembali']; ?></td>
                                <td><?= $r['tgl_pengembalian']; ?></td>
                                <td><?= $r['total_denda']; ?></td>  
                            </tr>
                        <?php } ?>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</center>
</div>