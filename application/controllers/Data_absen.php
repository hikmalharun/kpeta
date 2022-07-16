<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_absen extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    // public function __construct()
    // {
    //     parent::__construct();

    //     if ($this->session->userdata('role_id') != 2) {
    //         $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Maaf silahkan login terlebih dahulu</div>');
    //         redirect('authentication');
    //     }
    // }

    private function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function index()
    {
        //Start Hari Tanggal
        $days = array(
            1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );
        $hari = date_default_timezone_set('Asia/Jakarta');
        $hari = date('d-m-Y');
        $hari = date('N', strtotime($hari));
        $tanggal = date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->tgl_indo(date('Y-m-j'));
        $data['tanggal'] = $days[$hari] . ', ' . $tanggal;
        //End Hari Tanggal
        $data['rekap_all_masuk'] = $this->db->get_where('absen_masuk', ['tanggal_absen' => date('Y-m-d')])->result_array();
        $data['rekap_all_pulang'] = $this->db->get_where('absen_pulang', ['tanggal_absen' => date('Y-m-d')])->result_array();
        $data['title'] = "DATA ABSEN";
        $this->load->view('data_absen', $data);
    }
}
