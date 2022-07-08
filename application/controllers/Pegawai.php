<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;
use PhpOffice\PhpSpreadsheet\Worksheet;

class Pegawai extends CI_Controller
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

        if ($this->session->userdata('role_id') != 2) {
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Maaf silahkan login terlebih dahulu</div>');
            redirect('authentication');
        }
    }

    public function profile()
    {
        $data['title'] = "PROFILE";
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('profile', $data);
    }

    public function edit_profile()
    {
        $data['title'] = "EDIT PROFILE";
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('edit_profile', $data);
    }

    public function edit_password()
    {
        $id = $this->input->post('id');
        $old = md5($this->input->post('old_password'));
        $new1 = $this->input->post('password1');
        $new2 = $this->input->post('password2');

        $data_user = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        if ($data_user['password'] == $old) {
            if ($new1 == $new2) {
                $where = array(
                    'id' => $id
                );
                $data = array(
                    'password' => md5($new1)
                );
                $this->Pegawai_model->edit_password($data, $where);
                $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Password berhasil disimpan.</div>');
                redirect('pegawai/edit_profile');
            } else {
                $this->session->set_flashdata('profile', '<div class="alert alert-danger fade show" role="alert">Password yang anda masukan tidak cocok.</div>');
                redirect('pegawai/edit_profile');
            }
        } else {
            $this->session->set_flashdata('profile', '<div class="alert alert-danger fade show" role="alert">Password lama yang anda masukan salah.</div>');
            redirect('pegawai/edit_profile');
        }
    }

    public function edit_gambar()
    {
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        $id = $this->input->post('id');
        $gambar = $_FILES['gambar']['name'];

        if ($gambar) {
            $config['upload_path']          = './assets/images/profile';
            $config['allowed_types']        = 'jpg|jpeg';
            $config['max_size']             = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                $old_gambar = $data['user']['gambar'];
                if ($old_gambar != 'default.jpg'); {
                    unlink(FCPATH . 'assets/images/profile/' . $old_gambar);
                }
                $new_gambar = $this->upload->data('file_name');
                $this->db->set('gambar', $new_gambar);
            } else {
                $this->session->set_flashdata('profile', '<div class="alert alert-danger fade show" role="alert">Gambar gagal diupload.</div>');
                redirect('pegawai/edit_profile');
            }
        }

        $this->db->where('id', $id);
        $this->db->update('pengguna');

        $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Gambar berhasil diubah.</div>');
        redirect('pegawai/edit_profile');
    }

    public function simpan()
    {
        $nama = $this->input->post('name');
        $jabatan = $this->input->post('jabatan');
        $alamat = $this->input->post('alamat');

        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $id = $data['user']['id'];
        $old_nama = $data['user']['name'];
        $old_jabatan = $data['user']['jabatan'];
        $old_alamat = $data['user']['alamat'];

        $case1 = $nama . $jabatan . $alamat;
        $case2 = $old_nama . $old_jabatan . $old_alamat;

        if ($case1 != $case2) {
            $data_change = array(
                'name' => $nama,
                'jabatan' => $jabatan,
                'alamat' => $alamat
            );
            $this->db->set($data_change);
        } else {
            $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Tidak ada data yang diubah.</div>');
            redirect('pegawai/profile');
        }

        $this->db->where('id', $id);
        $this->db->update('pengguna');

        $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Data profile berhasil diubah.</div>');
        redirect('pegawai/profile');
    }

    function absen_masuk()
    {
        $masuk = $this->db->get_where('absen_masuk', ['email' => $this->session->userdata('email'), 'tanggal_absen' => date('Y-m-d')])->num_rows();

        $data['skema'] = $this->db->get_where('skema', ['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        $nows = date_default_timezone_set('Asia/Jakarta');
        $nows = date('H:i:s');
        $jam = strtotime($nows);

        $jam_masuk = strtotime($data['skema']['masuk']);
        $batas_awal_masuk = $jam_masuk - 7200;
        $batas_akhir_masuk = $jam_masuk + 7200;

        if ($masuk == 0) {
            if ($jam > $batas_awal_masuk || $jam < $batas_akhir_masuk) {
                $data['title'] = "ABSEN";
                $this->load->view('absen_masuk', $data);
            } else {
                redirect('dashboard');
            }
        } else {
            redirect('dashboard');
        }
    }

    function absen_pulang()
    {
        $pulang = $this->db->get_where('absen_pulang', ['email' => $this->session->userdata('email'), 'tanggal_absen' => date('Y-m-d')])->num_rows();

        $data['skema'] = $this->db->get_where('skema', ['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        $nows = date_default_timezone_set('Asia/Jakarta');
        $nows = date('H:i:s');
        $jam = strtotime($nows);

        $jam_pulang = strtotime($data['skema']['pulang']);
        $batas_akhir_pulang = $jam_pulang + 7200;

        if ($pulang == 0) {
            if ($jam > $jam_pulang && $jam < $batas_akhir_pulang) {
                $data['title'] = "ABSEN";
                $this->load->view('absen_pulang', $data);
            } else {
                redirect('dashboard');
            }
        } else {
            redirect('dashboard');
        }
    }

    function upload_image()
    {
        if (isset($_FILES["user_image"])) {
            $extension = explode('.', $_FILES['user_image']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = './upload/' . $new_name;
            move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
            return $new_name;
        }
    }

    public function submit_absen_masuk()
    {
        $this->load->library('geonames');
        $longitude = $this->input->post('longitude');
        $latitude = $this->input->post('latitude');

        $email =  $this->session->userdata('email');
        $skema = $this->db->get_where('skema', ['email' => $email])->row_array();

        $lat1 = $latitude;
        $lat2 = $skema['latitude'];
        $long1 = $longitude;
        $long2 = $skema['longitude'];
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $jarak = $miles * 1609;

        $data  = ['lat' => $latitude, 'long' => $longitude];
        $geolocation = isset(json_decode($this->geonames->getPlaceName($data))->geonames[0]) ? json_decode($this->geonames->getPlaceName($data))->geonames[0] : null;
        $address = '';
        if ($geolocation) {
            $address = $geolocation->name . ', ' . $geolocation->adminName1 . ', ' . $geolocation->countryName;
        }

        date_default_timezone_set('Asia/Jakarta');

        $image = $this->input->post('image');
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = base64_decode($image);
        $filename = 'image_' . time() . '.png';
        file_put_contents(FCPATH . '/uploads/' . $filename, $image);

        $row_user = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        $data = array(
            'nama' => $row_user['name'],
            'email' =>  $row_user['email'],
            'sekolah' => $row_user['sekolah'],
            'id_pengguna' =>  $row_user['id'],
            'jarak' => $jarak,
            'jam_absen' => date('H:i:s'),
            'tanggal_absen' => date('Y-m-d'),
            'koordinat' => $latitude . ',' . $longitude,
            'gambar' => $filename,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address
        );

        $res = $this->db->insert('absen_masuk', $data);
        $this->session->set_flashdata('absen', '<div class="alert alert-success fade show" role="alert">Absen Tersimpan.</div>');
        echo json_encode($res);
    }

    public function submit_absen_pulang()
    {
        $this->load->library('geonames');
        $longitude = $this->input->post('longitude');
        $latitude = $this->input->post('latitude');

        $email =  $this->session->userdata('email');
        $skema = $this->db->get_where('skema', ['email' => $email])->row_array();

        $lat1 = $latitude;
        $lat2 = $skema['latitude'];
        $long1 = $longitude;
        $long2 = $skema['longitude'];
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $jarak = $miles * 1609;

        $data  = ['lat' => $latitude, 'long' => $longitude];
        $geolocation = isset(json_decode($this->geonames->getPlaceName($data))->geonames[0]) ? json_decode($this->geonames->getPlaceName($data))->geonames[0] : null;
        $address = '';
        if ($geolocation) {
            $address = $geolocation->name . ', ' . $geolocation->adminName1 . ', ' . $geolocation->countryName;
        }

        date_default_timezone_set('Asia/Jakarta');

        $image = $this->input->post('image');
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = base64_decode($image);
        $filename = 'image_' . time() . '.png';
        file_put_contents(FCPATH . '/uploads/' . $filename, $image);

        $row_user = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        $data = array(
            'nama' => $row_user['name'],
            'email' =>  $row_user['email'],
            'sekolah' => $row_user['sekolah'],
            'id_pengguna' =>  $row_user['id'],
            'jarak' => $jarak,
            'jam_absen' => date('H:i:s'),
            'tanggal_absen' => date('Y-m-d'),
            'koordinat' => $latitude . ',' . $longitude,
            'gambar' => $filename,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address
        );

        $res = $this->db->insert('absen_pulang', $data);
        $this->session->set_flashdata('absen', '<div class="alert alert-success fade show" role="alert">Absen Tersimpan.</div>');
        echo json_encode($res);
    }
}
