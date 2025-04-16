<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller C_Auth
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class C_Auth extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->model('Auth_model');
 }

 public function index()
 {
  $this->session->sess_destroy();
  $this->load->view('auth/loginPage');
 }

 public function LoginProcess()
 {
  $user = $this->Auth_model->Login();
  if ($user) {
   $this->session->set_userdata('id_user', $user['id_user']);
   $this->session->set_userdata('username', $user['username']);
   $this->session->set_userdata('nama', $user['nama']);
   $this->session->set_userdata('role', $user['role']);
   if ($this->session->userdata('role') == 'Tim Penilai') {
    redirect(base_url() . 'C_Penilai');
   } elseif ($this->session->userdata('role') == 'KepSek') {
    redirect(base_url() . 'C_KepSek');
   } elseif ($this->session->userdata('role') == 'Admin') {
    redirect(base_url() . 'C_Admin');
   } elseif ($this->session->userdata('role') == 'Karyawan') {
    redirect(base_url() . 'C_Karyawan');
   } else {
    $this->session->set_flashdata('error', 'Akun anda tidak memiliki Role!');
    redirect(base_url() . 'C_Auth');
   }
  } else {
   $this->session->set_flashdata('error', 'Username atau Password salah!');
   redirect(base_url() . 'C_Auth');
  }
 }

 public function Logout()
 {
  $this->session->sess_destroy();
  redirect(base_url() . 'C_Auth');
 }

 public function unauthorized()
 {
  $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
  $this->load->view('auth/unauthorized');
  $this->load->view('templates/footer');
 }

}


/* End of file C_Auth.php */
/* Location: ./application/controllers/C_Auth.php */
