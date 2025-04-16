<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
	*
	* Controller C_Admin
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

class C_Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Admin_model');
	}

	public function index()
	{
		check_access(['Admin']);
		$data = $this->Admin_model->getDashboardStats();
		$data['divisi_data'] = $this->Admin_model->getDivisiData();
		$data['divisi_summary'] = $this->Admin_model->getDivisiSummary();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates/footer');
	}

	public function divisi()
	{
		check_access(['Admin']);
		$data['divisi'] = $this->Admin_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/divisi', $data);
		$this->load->view('templates/footer');
	}

	public function formTambahDivisi()
	{
		check_access(['Admin']);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formTambahDivisi');
		$this->load->view('templates/footer');
	}

	public function tambahDivisi()
	{
		check_access(['Admin']);
		$this->Admin_model->tambahDivisi();
		redirect(base_url() . 'C_Admin/divisi?status=added');
	}

	public function formEditDivisi($id)
	{
		check_access(['Admin']);
		$data['divisi'] = $this->Admin_model->getDivisiID($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formEditDivisi', $data);
		$this->load->view('templates/footer');
	}

	public function updateDivisi()
	{
		check_access(['Admin']);
		$this->Admin_model->updateDivisi();
		redirect(base_url() . 'C_Admin/divisi?status=updated');
	}

	public function hapusDivisi($id)
	{
		check_access(['Admin']);
		$this->Admin_model->hapusDivisi($id);
		redirect(base_url() . 'C_Admin/divisi?status=deleted');
	}

	public function karyawan()
	{
		check_access(['Admin']);
		$data['karyawan'] = $this->Admin_model->getAllKaryawan();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/karyawan', $data);
		$this->load->view('templates/footer');
	}

	public function formTambahKaryawan()
	{
		check_access(['Admin']);
		$data['divisi'] = $this->Admin_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formTambahKaryawan', $data);
		$this->load->view('templates/footer');
	}

	public function tambahKaryawan()
	{
		check_access(['Admin']);
		$this->Admin_model->tambahKaryawan();
		redirect(base_url() . 'C_Admin/karyawan?status=added');
	}

	public function formEditKaryawan($id)
	{
		check_access(['Admin']);
		$data['karyawan'] = $this->Admin_model->getKaryawanID($id);
		$data['divisi'] = $this->Admin_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formEditKaryawan', $data);
		$this->load->view('templates/footer');
	}

	public function updateKaryawan()
	{
		check_access(['Admin']);
		$this->Admin_model->updateKaryawan();
		redirect(base_url() . 'C_Admin/karyawan?status=updated');
	}

	public function hapusKaryawan($id)
	{
		check_access(['Admin']);
		$this->Admin_model->hapusKaryawan($id);
		redirect(base_url() . 'C_Admin/karyawan?status=deleted');
	}

	public function penilai()
	{
		check_access(['Admin']);
		$data['penilai'] = $this->Admin_model->getAllPenilai();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/penilai', $data);
		$this->load->view('templates/footer');
	}

	public function formTambahTimPenilai()
	{
		check_access(['Admin']);
		$data['divisi'] = $this->Admin_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formTambahPenilai', $data);
		$this->load->view('templates/footer');
	}

	public function tambahPenilai()
	{
		check_access(['Admin']);
		$this->Admin_model->tambahPenilai();
		redirect(base_url() . 'C_Admin/penilai?status=added');
	}

	public function formEditTimPenilai($id)
	{
		check_access(['Admin']);
		$data['penilai'] = $this->Admin_model->getPenilaiID($id);
		$data['divisi'] = $this->Admin_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formEditPenilai', $data);
		$this->load->view('templates/footer');
	}

	public function updatePenilai()
	{
		check_access(['Admin']);
		$this->Admin_model->updatePenilai();
		redirect(base_url() . 'C_Admin/penilai?status=updated');
	}

	public function hapusPenilai($id)
	{
		check_access(['Admin']);
		$this->Admin_model->hapusPenilai($id);
		redirect(base_url() . 'C_Admin/penilai?status=deleted');
	}

	public function editProfil($id)
	{
		check_access(['Admin', 'Tim Penilai', 'KepSek', 'Karyawan']);
		$data['user'] = $this->Admin_model->getUserID($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/formEditProfil', $data);
		$this->load->view('templates/footer');
	}

	public function updateProfil()
	{
		check_access(['Admin', 'Tim Penilai', 'KepSek', 'Karyawan']);
		$this->Admin_model->updateUser();
		$this->session->set_userdata('username', $this->input->post('username'));
		$this->session->set_userdata('nama', $this->input->post('nama'));
		redirect(base_url() . 'C_Admin/editProfil/' . $this->session->userdata('id_user') . '?status=updated');
	}

}


/* End of file C_Admin.php */
/* Location: ./application/controllers/C_Admin.php */
