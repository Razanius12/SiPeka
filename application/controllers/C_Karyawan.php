<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller C_Karyawan
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

class C_Karyawan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		check_access(['Karyawan']);
		$this->load->model('Karyawan_model');
	}

	public function index()
	{
		$data['performance'] = $this->Karyawan_model->getPerformanceStats();
		$data['recent_jobs'] = $this->Karyawan_model->getRecentJobsheets(3);
		$data['revised_jobs'] = $this->Karyawan_model->getRevisedJobsheets();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/dashboard', $data);
		$this->load->view('templates/footer');
	}

	public function jobsheetPending()
	{
		$data['jobsheet'] = $this->Karyawan_model->getAllPendingJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/jobsheetPending', $data);
		$this->load->view('templates/footer');
	}

	public function detailJobsheet($id)
	{
		$data['jobsheet'] = $this->Karyawan_model->detailJobsheet($id);
		$data['ref_attachments'] = $this->Karyawan_model->getAttachments($data['jobsheet']['references_id']);
		$data['revisions'] = $this->Karyawan_model->getJobsheetRevisions($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/detailJobsheet', $data);
		$this->load->view('templates/footer');
	}

	public function ambilJobsheet($id)
	{
		$this->Karyawan_model->ambilJobsheet($id);
		redirect('C_Karyawan/jobsheetOnProgress?status=ambil');
	}

	public function jobsheetOnProgress()
	{
		$data['jobsheet'] = $this->Karyawan_model->getAllOnProgressJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/jobsheetOnProgress', $data);
		$this->load->view('templates/footer');
	}

	public function selesaikanJobsheet($id)
	{
		$data['jobsheet'] = $this->Karyawan_model->detailJobsheet($id);
		$data['ref_attachments'] = $this->Karyawan_model->getAttachments($data['jobsheet']['references_id']);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/selesaikanJobsheet', $data);
		$this->load->view('templates/footer');
	}

	public function submitJobsheet()
	{
		$this->Karyawan_model->submitJobsheet();
		redirect('C_Karyawan/jobsheetCompleted?status=selesai');
	}

	public function jobsheetCompleted()
	{
		$data['jobsheet'] = $this->Karyawan_model->getAllCompletedJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/jobsheetCompleted', $data);
		$this->load->view('templates/footer');
	}

	public function detailJobsheetCompleted($id)
	{
		$data['jobsheet'] = $this->Karyawan_model->detailJobsheet($id);
		$data['ref_attachments'] = $this->Karyawan_model->getAttachments($data['jobsheet']['references_id']);
		$data['result_attachments'] = $this->Karyawan_model->getAttachments($data['jobsheet']['attach_result_id']);
		$data['revisions'] = $this->Karyawan_model->getJobsheetRevisions($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/detailJobsheetCompleted', $data);
		$this->load->view('templates/footer');
	}

	public function jobsheetRevisions()
	{
		$data['revised_jobs'] = $this->Karyawan_model->getRevisedJobsheets();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/jobsheetRevisions', $data);
		$this->load->view('templates/footer');
	}

	public function kinerja()
	{
		$data['performance'] = $this->Karyawan_model->getPerformanceStats();
		$data['recent_jobs'] = $this->Karyawan_model->getRecentJobsheets();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('karyawan/kinerja', $data);
		$this->load->view('templates/footer');
	}
}


/* End of file C_Karyawan.php */
/* Location: ./application/controllers/C_Karyawan.php */
