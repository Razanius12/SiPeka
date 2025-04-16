<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller C_Home
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

class C_Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
	}

	public function index()
	{
		$data['stats'] = $this->Home_model->getSystemStats();
		$data['top_performers'] = $this->Home_model->getTopPerformers();
		$data['completion_rates'] = $this->Home_model->getDivisionCompletionRates();
		$data['recent_activities'] = $this->Home_model->getRecentActivities();

		$this->load->view('templates/landing', $data);
	}

}


/* End of file C_Home.php */
/* Location: ./application/controllers/C_Home.php */
