<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller C_KepSek
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

class C_KepSek extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
		$this->load->helper('auth');
		check_access(['KepSek']);
 }

	public function index()
	{
		$this->load->model('Penilai_model');
		$performance = $this->Penilai_model->getPerformanceStats(null, 'month');
		$data['total_karyawan'] = count($performance);

		$total_completion = 0;
		$total_active = 0;
		$total_overdue = 0;

		foreach ($performance as $p) {
			$total_completion += $p['completion_rate'];
			$total_active += ($p['onprogress_jobs'] + $p['pending_jobs']);
			$total_overdue += $p['overdue_tasks'];
		}

		$data['completion_rate'] = $data['total_karyawan'] ? round($total_completion / $data['total_karyawan']) : 0;
		$data['total_active_tasks'] = $total_active;
		$data['overdue_tasks'] = $total_overdue;
		$data['performance_data'] = $this->Penilai_model->getDivisiPerformance();
		$data['recent_activities'] = $this->Penilai_model->getRecentActivities();
		$data['tasks_by_division'] = $this->Penilai_model->getTasksByDivision();
		$data['top_performers'] = $this->Penilai_model->getTopPerformers();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/dashboard', $data);
		$this->load->view('templates/footer');
	}

}


/* End of file C_KepSek.php */
/* Location: ./application/controllers/C_KepSek.php */
