<?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Pengembalian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ModelUser', 'ModelBuku', 'ModelPinjam']);
        cek_login();
        cek_user();
    }

    public function index()
    {
        $data['judul'] = "Daftar Pengembalian";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['pengembalian'] = $this->db->query("select*from pinjam where status='pinjam'")->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pinjam/pengembalian', $data);
        $this->load->view('templates/footer');
    }

    public function kembaliAct()
    {
        $no_pinjam = $this->uri->segment(3);
        $detail_pinjam = $this->db->query("select*from detail_pinjam where no_pinjam='$no_pinjam'")->result_array();
        $id_buku = $detail_pinjam[0]['id_buku'];
        $data_pinjam = $this->db->query("select*from pinjam, detail_pinjam where pinjam.no_pinjam=detail_pinjam.no_pinjam and detail_pinjam.id_buku='$id_buku' and pinjam.no_pinjam='$no_pinjam'")->result_array();
        $tgl_kembali = $data_pinjam[0]['tgl_kembali'];
        $tgl_sekarang = date('Y-m-d');
        $denda = $data_pinjam[0]['denda'];
        $status = 'Kembali';
        
        // Mengonversi tanggal menjadi objek DateTime
        $tgl_kembali_obj = new DateTime($tgl_kembali);
        $tgl_sekarang_obj = new DateTime($tgl_sekarang);

        // Menghitung selisih antara kedua tanggal
        $selisih = date_diff($tgl_kembali_obj, $tgl_sekarang_obj)->days;

        if ($tgl_sekarang > $tgl_kembali) {
            $total_denda = $denda * $selisih;
            // update status menjadi kembali pada saat buku dikembalikan
            $this->db->query("UPDATE pinjam, detail_pinjam SET pinjam.status='$status', pinjam.tgl_pengembalian='$tgl_sekarang', pinjam.total_denda='$total_denda' WHERE detail_pinjam.id_buku='$id_buku' AND pinjam.no_pinjam='$no_pinjam'");
        } else {
            $total_denda = 0;
            // update status menjadi kembali pada saat buku dikembalikan
            $this->db->query("UPDATE pinjam, detail_pinjam SET pinjam.status='$status', pinjam.tgl_pengembalian='$tgl_sekarang', pinjam.total_denda='$total_denda' WHERE detail_pinjam.id_buku='$id_buku' AND pinjam.no_pinjam='$no_pinjam'");
        }
        
        // update stok dan dipinjam pada tabel buku
        foreach ($detail_pinjam as $d) {
            $this->db->query("UPDATE buku SET buku.dipinjam=buku.dipinjam-1, stok=stok+1 WHERE buku.id='$d[id_buku]'");
        }
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-message alert-success" role="alert"></div>');
        redirect(base_url('pinjam'));
    }
}
