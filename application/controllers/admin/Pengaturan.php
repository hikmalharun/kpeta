<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
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
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Maaf silahkan login terlebih dahulu</div>');
            redirect('authentication');
        }
    }

    public function index()
    {
        $data['title'] = "PENGATURAN";
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('pengaturan', $data);
    }

    public function skema()
    {
        $data['title'] = "PENGATURAN | SKEMA";
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $data['skema'] = $this->db->get_where('skema', ['email' => $this->session->userdata('email')])->row_array();
        $data['lokasi'] = $this->db->get_where('set_lokasi', ['status' => 1])->result_array();
        $data['jam'] = $this->db->get_where('set_jam', ['status' => 1])->result_array();
        $this->load->view('skema', $data);
    }

    public function save_lokasi()
    {
        $email = $this->input->post('email');
        $skema = $this->input->post('skema');
        if ($skema == 1) {
            $lokasi = "SMAN 1 ANJATAN";
        } else {
            $lokasi = "XXX";
        }

        $this->db->set('lokasi', $lokasi);
        $this->db->where('email', $email);
        $this->db->update('skema');
        $this->session->set_flashdata('pengaturan', '<div class="alert alert-success" role="alert">Skema berhasil disimpan.</div>');
        redirect('admin/pengaturan/skema');
    }
}
