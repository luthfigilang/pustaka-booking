<?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Pinjam extends CI_Controller
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
        $data['judul'] = "Data Pinjam";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['pinjam'] = $this->ModelPinjam->joinData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pinjam/data-pinjam', $data);
        $this->load->view('templates/footer');
    }

    public function daftarBooking()
    {
        $data['judul'] = "Daftar Booking";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['pinjam'] = $this->db->query("select*from booking")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('booking/daftar-booking', $data);
        $this->load->view('templates/footer');
    }

    public function bookingDetail()
    {
        $id_booking = $this->uri->segment(3);
        $data['judul'] = "Booking Detail";
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['agt_booking'] = $this->db->query("select*from booking b, user u where b.id_user=u.id and b.id_booking='$id_booking'")->result_array();
        $data['detail'] = $this->db->query("select id_buku,judul_buku,pengarang,penerbit,tahun_terbit from booking_detail d, buku b where d.id_buku=b.id and d.id_booking='$id_booking'")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('booking/booking-detail', $data);
        $this->load->view('templates/footer');
    }

    public function pinjamAct()
    {
        $id_booking = $this->uri->segment(3);
        $lama = $this->input->post('lama', TRUE);
        $detail = $this->db->query("select*from booking_detail d, buku b where d.id_buku=b.id and d.id_booking='$id_booking'")->result_array();

        $bo = $this->db->query("SELECT*FROM booking WHERE id_booking='$id_booking'")->row();

        $tglsekarang = date('Y-m-d');
        $no_pinjam = $this->ModelBooking->kodeotomatis('pinjam', 'no_pinjam');
        $databooking = [
            'no_pinjam' => $no_pinjam,
            'id_booking' => $id_booking,
            'tgl_pinjam' => $tglsekarang,
            'id_user' => $bo->id_user,
            'tgl_kembali' => date('Y-m-d', strtotime('+' . $lama . ' days', strtotime($tglsekarang))),
            'tgl_pengembalian' => '0000-00-00',
            'status' => 'Pinjam',
            'total_denda' => 0
        ];
        $this->ModelPinjam->simpanPinjam($databooking);
        $this->ModelPinjam->simpanDetail($id_booking, $no_pinjam);
        $denda = $this->input->post('denda', TRUE);
        $this->db->query("UPDATE detail_pinjam SET denda = '$denda' WHERE no_pinjam = '$no_pinjam'");

        //hapus Data booking yang bukunya diambil untuk dipinjam
        $this->ModelPinjam->deleteData('booking', ['id_booking' => $id_booking]);
        $this->ModelPinjam->deleteData('booking_detail', ['id_booking' => $id_booking]);

        //update dibooking dan dipinjam pada tabel buku saat buku yang dibooking diambil untuk dipinjam
        foreach ($detail as $d) {
            $this->db->query("update buku set dipinjam=dipinjam+1, dibooking=dibooking-1 where id='$d[id_buku]'");
        }

        redirect(base_url() . 'pengembalian');
    }

    public function ubahStatus()
    {
        $id_buku = $this->uri->segment(3);
        $no_pinjam = $this->uri->segment(4);
        $where = ['id_buku' => $this->uri->segment(3),];
        $data_pinjam = $this->db->query("select*from pinjam, detail_pinjam where pinjam.no_pinjam=detail_pinjam.no_pinjam and detail_pinjam.id_buku='$id_buku' and pinjam.no_pinjam='$no_pinjam'")->result_array();
        var_dump($data_pinjam);
        die;
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
        foreach ($data_pinjam as $d) {
            $this->db->query("UPDATE buku SET buku.dipinjam=buku.dipinjam-1, buku.stok=buku.stok+1 WHERE buku.id='$d[id_buku]'");
        }
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-message alert-success" role="alert"></div>');
        redirect(base_url('pinjam'));
    }
}
