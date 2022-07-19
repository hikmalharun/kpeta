<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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

        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Maaf silahkan login terlebih dahulu</div>');
            redirect('authentication');
        }
    }

    public function data_pegawai()
    {
        $data['title'] = "DATA PEGAWAI";
        $data['sekolah'] = $this->Pegawai_model->getSekolah();
        $data['data_pegawai'] = $this->Pegawai_model->getPegawai();
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->db->get_where('daftar_pegawai', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('admin/data_pegawai', $data);
    }

    public function import_pegawai()
    {
        $upload_file = $_FILES['upload_file']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);

        $sheetPegawai = $spreadsheet->getActiveSheet()->toArray();

        $id = $this->input->post('id');
        foreach ($this->Pegawai_model->getWhereSekolah($id) as $skl) {
            $sheetcount = count($sheetPegawai);
            if ($sheetcount > 1) {
                $data = array();
                for ($i = 5; $i < $sheetcount; $i++) {
                    $sekolah = $skl->nama;
                    $npsn = $skl->npsn;
                    $nama = $sheetPegawai[$i][1];
                    $nuptk = $sheetPegawai[$i][2];
                    $jk = $sheetPegawai[$i][3];
                    $tempat_lahir = $sheetPegawai[$i][4];
                    $tanggal_lahir = $sheetPegawai[$i][5];
                    $nip = $sheetPegawai[$i][6];
                    if ($sheetPegawai[$i][20] == 'Kepala Sekolah') {
                        $status_kepegawaian = $sheetPegawai[$i][7] . '_Kepala_Sekolah';
                    } else {
                        $status_kepegawaian = $sheetPegawai[$i][7];
                    }
                    $jenis_ptk = $sheetPegawai[$i][8];
                    $agama = $sheetPegawai[$i][9];
                    $alamat_jalan = $sheetPegawai[$i][10];
                    $rt = $sheetPegawai[$i][11];
                    $rw = $sheetPegawai[$i][12];
                    $nama_dusun = $sheetPegawai[$i][13];
                    $desa_kelurahan = $sheetPegawai[$i][14];
                    $kecamatan = $sheetPegawai[$i][15];
                    $kode_pos = $sheetPegawai[$i][16];
                    $telepon = $sheetPegawai[$i][17];
                    $hp = $sheetPegawai[$i][18];
                    $email = $sheetPegawai[$i][19];
                    $tugas_tambahan = $sheetPegawai[$i][20];
                    $sk_cpns = $sheetPegawai[$i][21];
                    $tanggal_cpns = $sheetPegawai[$i][22];
                    $sk_pengangkatan = $sheetPegawai[$i][23];
                    $tmt_pengangkatan = $sheetPegawai[$i][24];
                    $lembaga_pengangkatan = $sheetPegawai[$i][25];
                    $pangkat_golongan = $sheetPegawai[$i][26];
                    $sumber_gaji = $sheetPegawai[$i][27];
                    $nama_ibu_kandung = $sheetPegawai[$i][28];
                    $status_perkawinan = $sheetPegawai[$i][29];
                    $nama_suami_istri = $sheetPegawai[$i][30];
                    $nip_suami_istri = $sheetPegawai[$i][31];
                    $pekerjaan_suami_istri = $sheetPegawai[$i][32];
                    $tmt_pns = $sheetPegawai[$i][33];
                    $sudah_lisensi_kepala_sekolah = $sheetPegawai[$i][34];
                    $pernah_diklat_kepengawasan = $sheetPegawai[$i][35];
                    $keahlian_braille = $sheetPegawai[$i][36];
                    $keahlian_bahasa_isyarat = $sheetPegawai[$i][37];
                    $npwp = $sheetPegawai[$i][38];
                    $nama_wajib_pajak = $sheetPegawai[$i][39];
                    $kewarganegaraan = $sheetPegawai[$i][40];
                    $bank = $sheetPegawai[$i][41];
                    $nomor_rekening_bank = $sheetPegawai[$i][42];
                    $rekening_atas_nama = $sheetPegawai[$i][43];
                    $nik = $sheetPegawai[$i][44];
                    $no_kk = $sheetPegawai[$i][45];
                    $karpeg = $sheetPegawai[$i][46];
                    $karis_karsu = $sheetPegawai[$i][47];
                    $lintang = $sheetPegawai[$i][48];
                    $bujur = $sheetPegawai[$i][49];
                    $nuks = $sheetPegawai[$i][50];

                    date_default_timezone_set("Asia/Jakarta");

                    $data[] = array(
                        'sekolah' => $sekolah,
                        'npsn' => $npsn,
                        'nama' => $nama,
                        'nuptk' => $nuptk,
                        'jk' => $jk,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $tanggal_lahir,
                        'nip' => $nip,
                        'status_kepegawaian' => $status_kepegawaian,
                        'jenis_ptk' => $jenis_ptk,
                        'agama' => $agama,
                        'alamat_jalan' => $alamat_jalan,
                        'rt' => $rt,
                        'rw' => $rw,
                        'nama_dusun' => $nama_dusun,
                        'desa_kelurahan' => $desa_kelurahan,
                        'kecamatan' => $kecamatan,
                        'kode_pos' => $kode_pos,
                        'telepon' => $telepon,
                        'hp' => $hp,
                        'email' => $email,
                        'tugas_tambahan' => $tugas_tambahan,
                        'sk_cpns' => $sk_cpns,
                        'tanggal_cpns' => $tanggal_cpns,
                        'sk_pengangkatan' => $sk_pengangkatan,
                        'tmt_pengangkatan' => $tmt_pengangkatan,
                        'lembaga_pengangkatan' => $lembaga_pengangkatan,
                        'pangkat_golongan' => $pangkat_golongan,
                        'sumber_gaji' => $sumber_gaji,
                        'nama_ibu_kandung' => $nama_ibu_kandung,
                        'status_perkawinan' => $status_perkawinan,
                        'nama_suami_istri' => $nama_suami_istri,
                        'nip_suami_istri' => $nip_suami_istri,
                        'pekerjaan_suami_istri' => $pekerjaan_suami_istri,
                        'tmt_pns' => $tmt_pns,
                        'sudah_lisensi_kepala_sekolah' => $sudah_lisensi_kepala_sekolah,
                        'pernah_diklat_kepengawasan' => $pernah_diklat_kepengawasan,
                        'keahlian_braille' => $keahlian_braille,
                        'keahlian_bahasa_isyarat' => $keahlian_bahasa_isyarat,
                        'npwp' => $npwp,
                        'nama_wajib_pajak' => $nama_wajib_pajak,
                        'kewarganegaraan' => $kewarganegaraan,
                        'bank' => $bank,
                        'nomor_rekening_bank' => $nomor_rekening_bank,
                        'rekening_atas_nama' => $rekening_atas_nama,
                        'nik' => $nik,
                        'no_kk' => $no_kk,
                        'karpeg' => $karpeg,
                        'karis_karsu' => $karis_karsu,
                        'lintang' => $lintang,
                        'bujur' => $bujur,
                        'nuks' => $nuks
                    );
                }

                $this->Pegawai_model->insert_pegawai($data);
                $this->session->set_flashdata('sukses', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">Upload data pegawai sukses.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ');
                redirect('admin/pegawai/data_pegawai');
            }
        }
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        $this->Pegawai_model->hapus_user($where);
        redirect('admin/pegawai/data_pegawai');
    }

    public function delete_pns()
    {
        $this->Pegawai_model->delete_pns();
        redirect('admin/pegawai/data_pegawai');
    }

    public function delete_pppk()
    {
        $this->Pegawai_model->delete_pppk();
        redirect('admin/pegawai/data_pegawai');
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
                redirect('admin/pegawai/edit_profile');
            } else {
                $this->session->set_flashdata('profile', '<div class="alert alert-danger fade show" role="alert">Password yang anda masukan tidak cocok.</div>');
                redirect('admin/pegawai/edit_profile');
            }
        } else {
            $this->session->set_flashdata('profile', '<div class="alert alert-danger fade show" role="alert">Password lama yang anda masukan salah.</div>');
            redirect('admin/pegawai/edit_profile');
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
                redirect('admin/pegawai/edit_profile');
            }
        }

        $this->db->where('id', $id);
        $this->db->update('pengguna');

        $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Gambar berhasil diubah.</div>');
        redirect('admin/pegawai/edit_profile');
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
            redirect('admin/pegawai/profile');
        }

        $this->db->where('id', $id);
        $this->db->update('pengguna');

        $this->session->set_flashdata('profile', '<div class="alert alert-success fade show" role="alert">Data profile berhasil diubah.</div>');
        redirect('admin/pegawai/profile');
    }

    public function add_user()
    {
        $name = $this->input->post('name');
        $sekolah = $this->input->post('sekolah');
        $email = $this->input->post('email');
        $nohp = $this->input->post('nohp');
        $length = 8;
        $password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 1, $length);
        $generate_password = md5($password);
        $is_sekolah = $this->db->get_where('daftar_pegawai', ['sekolah' => $sekolah])->row_array();

        //Generate token
        $leght_token = 77;
        $token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 1, $leght_token);

        $data = array(
            'name' => $name,
            'email' => $email,
            'npsn' => $is_sekolah['npsn'],
            'sekolah' => $is_sekolah['sekolah'],
            'jabatan' => '-',
            'alamat' => '-',
            'gambar' => 'default.jpg',
            'password' => $generate_password,
            'password_default' => $password,
            'role_id' => 2,
            'status' => 0,
            'nohp' => $nohp,
            'token' => $token,
            'tanggal_add' => time(),
        );
        $user_token = [
            'email' => $email,
            'token' => $token,
            'tanggal_add' => time()
        ];
        $this->Authtentication_model->insert_pengguna('pengguna', $data);
        $this->Authtentication_model->insert_token('token', $user_token);

        $data_skema = array(
            'email' => $email,
            'npsn' => $is_sekolah['npsn'],
            'sekolah' => $is_sekolah['sekolah'],
            'lokasi' => $is_sekolah['sekolah'],
            'masuk' => '07:30:00',
            'pulang' => '16:00:00',
            'status' => '1',
            'latitude' => '-6.373581',
            'longitude' => '107.957511',
            'koordinat' => '-6.373581, 107.957511',
            'tanggal_add' => date('Y-m-d')
        );
        $this->Authtentication_model->insert_skema('skema', $data_skema);

        //$type = 'Verifikasi Akun K-PETA';
        //Kirim email verifikasi
        //$this->_sendEmail($token, $name, $password, $type);
        $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Silahkan lakukan verifikasi akun melalui whatsapp.</div>');
        redirect('admin/pegawai/data_pengguna');
    }

    private function _sendEmail($token, $name, $password, $type)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->CharSet = "utf-8"; // set charset to utf8
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->SMTPSecure = 'STARTTLS'; // Enable TLS encryption, `ssl` also accepted

        $mail->Host = 'smtp.office365.com'; // Specify main and backup SMTP servers
        $mail->Port = 465; // TCP port to connect to
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isHTML(true); // Set email format to HTML

        $mail->Username = 'k-peta@outlook.co.id'; // SMTP username
        $mail->Password = 'Rasidi250789'; // SMTP password

        $message = '
        <center><img src="https://info-ppdb2022.sman1anjatan.sch.id/assets/img/logo.webp" style="width:100px;"/></center>
        <h2 style="width:100%;heoght:200px;text-align:center;background-color:blue;color:white;margin:10px 0 10px 0;">Verifikasi Akun</h2><p>Kepada <b>Yth. ' . $name . '</b><br>
        Berikut kami kirim link verifikasi akun anda, caranya klik tombol berikut <br>
        <a href="' . base_url() . 'authentication/verify_account?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">
        <button style="background-color:green; color: white;width: 100%; height: 50px; border: 0px solid #fff; border-radius: 5px; cursor: pointer;">VERIFIKASI</button>
        </a><br>
        atau dengan cara klik link berikut : <br>
        <a href="' . base_url() . 'authentication/verify_account?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">' . base_url() . 'authentication/verify_account?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '</a><br><br>
        <table><tr><td>Username</td><td>:</td><td>' . $this->input->post('email') . '</td></tr><tr><td>Password</td><td>:</td><td>' . $password . '</td></tr></table><br><br>
        Waktu verifikasi akun hanya tersedia 24 jam setelah menerima link diatas.</p>
        ';

        $mail->setFrom('k-peta@outlook.co.id', 'ADMIN K-PETA SMAN 1 ANJATAN'); //Your application NAME and EMAIL
        $mail->Subject = $type; //Message subject
        $mail->addAddress($this->input->post('email'), $name); // Target email

        $mail->MsgHTML($message); // Message body
        $mail->send();
    }

    public function data_pengguna()
    {
        $data['title'] = "DATA PENGGUNA";
        $data['sekolah'] = $this->Pegawai_model->getSekolah();
        $data['data_pegawai'] = $this->Pegawai_model->getPegawai();
        $data['data_pengguna'] = $this->Pegawai_model->getPengguna();
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->db->get_where('daftar_pegawai', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('admin/data_pengguna', $data);
    }

    public function data_sekolah()
    {
        $data['title'] = "DATA SEKOLAH";
        $data['sekolah'] = $this->Pegawai_model->getSekolahAll();
        $data['data_pegawai'] = $this->Pegawai_model->getPegawai();
        $data['data_pengguna'] = $this->Pegawai_model->getPengguna();
        $data['user'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->db->get_where('daftar_pegawai', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('admin/data_sekolah', $data);
    }

    public function edit_sekolah()
    {
        $id = $this->input->post('id');
        $skl = $this->db->get_where('sekolah', ['id' => $id])->row_array();
        if ($skl['status'] == 1) {
            $this->db->set('status', 0);
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Sekolah berhasil dinonaktifkan.</div>');
        } else {
            $this->db->set('status', 1);
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Sekolah berhasil diaktifkan.</div>');
        }
        $this->db->where('id', $id);
        $this->db->update('sekolah');
        redirect('admin/pegawai/data_sekolah');
    }

    public function status()
    {
        $id = $this->input->post('id');
        $users = $this->db->get_where('pengguna', ['id' => $id])->row_array();

        if ($users['email'] == "hikmal.harun@gmail.com") {
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Pengguna ini tidak bisa dinonaktifkan.</div>');
        } else {
            if ($users['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }

            $this->db->set('status', $status);
            $this->db->where('id', $id);
            $this->db->update('pengguna');

            if ($status == 1) {
                $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Pengguna berhasil diaktifkan.</div>');
            } else {
                $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Pengguna berhasil dinonaktifkan.</div>');
            }
        }

        redirect('admin/pegawai/data_pengguna');
    }

    public function reset_password()
    {
        $id = $this->input->post('id');
        $users = $this->db->get_where('pengguna', ['id' => $id])->row_array();
        $password_default = md5($users['password_default']);

        if ($users['email'] == "hikmal.harun@gmail.com") {
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-danger" role="alert">Password pengguna ini tidak bisa direset.</div>');
        } else {
            $this->db->set('password', $password_default);
            $this->db->where('id', $id);
            $this->db->update('pengguna');
            $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Password pengguna berhasil direset.</div>');
        }
        redirect('admin/pegawai/data_pengguna');
    }

    public function reset_skema()
    {
        $email = $this->input->get('email');
        $jenis = $this->input->get('jenis');
        if ($jenis == 1) {
            $masuk = '07:30:00';
            $pulang = '16:00:00';
        } elseif ($jenis == 2) {
            $masuk = '07:00:00';
            $pulang = '15:30:00';
        } elseif ($jenis == 3) {
            $masuk = '18:00:00';
            $pulang = '06:00:00';
        }
        $skema_data = array(
            'masuk' => $masuk,
            'pulang' => $pulang,
            'latitude' => '-6.373581',
            'longitude' => '107.957511',
            'koordinat' => '-6.373581, 107.957511',
        );

        $this->db->set($skema_data);
        $this->db->where('email', $email);
        $this->db->update('skema');
        $this->session->set_flashdata('pesan_token', '<div class="alert alert-success" role="alert">Skema pengguna berhasil direset.</div>');
        redirect('admin/pegawai/data_pengguna');
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
        $batas_awal_masuk = $jam_masuk - (60 * 60 * 2);
        $batas_akhir_masuk = $jam_masuk + (60 * 60 * 2);

        if ($jam > $batas_awal_masuk || $jam < $batas_akhir_masuk) {
            if ($masuk == 0) {
                $data['title'] = "ABSEN";
                $this->load->view('absen_masuk', $data);
            } elseif ($masuk == 1) {
                redirect('admin/dashboard');
            }
        } else {
            redirect('admin/dashboard');
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
        $batas_akhir_pulang = $jam_pulang + (60 * 60 * 5);

        if ($jam > $jam_pulang && $jam < $batas_akhir_pulang) {
            if ($pulang == 0) {
                $data['title'] = "ABSEN";
                $this->load->view('absen_pulang', $data);
            } elseif ($pulang == 1) {
                redirect('admin/dashboard');
            }
        } else {
            redirect('admin/dashboard');
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
            'bulan' => date('m'),
            'tahun' => date('Y'),
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
            'bulan' => date('m'),
            'tahun' => date('Y'),
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
