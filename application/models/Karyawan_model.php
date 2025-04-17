<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Karyawan_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Karyawan_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function index()
	{
		// 
	}

	public function getAllPendingJobsheet()
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, CURDATE()) as days_left');
		$this->db->from('jobsheet');
		$this->db->where('jobsheet.status', 'PENDING');
		$this->db->where('jobsheet.id_user', $this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllOnProgressJobsheet()
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, CURDATE()) as days_left');
		$this->db->from('jobsheet');
		$this->db->where('jobsheet.status', 'ON PROGRESS');
		$this->db->where('jobsheet.id_user', $this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllCompletedJobsheet()
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, finished_at) as days_left');
		$this->db->from('jobsheet');
		$this->db->where('jobsheet.status', 'COMPLETED');
		$this->db->where('jobsheet.id_user', $this->session->userdata('id_user'));
		$query = $this->db->get();
		return $query->result_array();
	}

	public function ambilJobsheet($id)
	{
		$data = [
			'status' => 'ON PROGRESS'
		];
		$this->db->where('id_jobsheet', $id);
		$this->db->update('jobsheet', $data);
	}

	public function detailJobsheet($id)
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, CURDATE()) as days_left');
		$this->db->from('jobsheet');
		$this->db->where('jobsheet.id_jobsheet', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getAttachments($id)
	{
		return $this->db->get_where('attachments', ['id_attachment' => $id])->row_array();
	}

	public function uploadAttachments($files)
	{
		if (!isset($files['name']) || !is_array($files['name'])) {
			return null;
		}

		$upload_path = './uploads/jobsheet/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}

		$data = array();
		for ($i = 1; $i <= 5; $i++) {
			$data['atch' . $i] = '';
		}

		for ($i = 0; $i < min(count($files['name']), 5); $i++) {
			if (!empty($files['name'][$i])) {

				if (move_uploaded_file($files['tmp_name'][$i], $upload_path . $files['name'][$i])) {
					$data['atch' . ($i + 1)] = $files['name'][$i];
				}
			}
		}

		if (array_filter($data)) {
			$this->db->insert('attachments', $data);
			return $this->db->insert_id();
		}

		return null;
	}

	public function submitJobsheet()
	{
		$attach_result_id = null;
		if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
			$files = array();
			$file_count = count($_FILES['attachments']['name']);

			for ($i = 0; $i < $file_count; $i++) {
				$files['name'][$i] = $_FILES['attachments']['name'][$i];
				$files['type'][$i] = $_FILES['attachments']['type'][$i];
				$files['tmp_name'][$i] = $_FILES['attachments']['tmp_name'][$i];
				$files['error'][$i] = $_FILES['attachments']['error'][$i];
				$files['size'][$i] = $_FILES['attachments']['size'][$i];
			}

			$attach_result_id = $this->uploadAttachments($files);
		}

		$data = [
			'status' => 'COMPLETED',
			'finished_at' => date('Y-m-d H:i:s'),
			'attach_result_id' => $attach_result_id
		];

		$id_jobsheet = $this->input->post('id_jobsheet');
		$jobsheet = $this->detailJobsheet($id_jobsheet);

		if ($jobsheet['is_revision']) {
			$this->db->where('id_jobsheet', $id_jobsheet)
				->where('revision_count', $jobsheet['current_revision'])
				->update('jobsheet_revisions', [
					'karyawan_comment' => $this->input->post('karyawan_comment')
				]);
		}

		$this->db->where('id_jobsheet', $id_jobsheet);
		$this->db->update('jobsheet', $data);
	}

	public function getPerformanceStats()
	{
		$id_user = $this->session->userdata('id_user');

		$total_jobs = $this->db->where('id_user', $id_user)->count_all_results('jobsheet');

		$completed_jobs = $this->db->where('id_user', $id_user)
			->where('status', 'COMPLETED')
			->count_all_results('jobsheet');

		$ontime_jobs = $this->db->where('id_user', $id_user)
			->where('status', 'COMPLETED')
			->where('finished_at <= deadline')
			->count_all_results('jobsheet');


		$nilai_query = $this->db->select_sum('nilai')
			->where('id_user', $id_user)
			->where('status', 'COMPLETED')
			->get('jobsheet');
		$total_nilai = $nilai_query->row()->nilai;
		$average_nilai = $completed_jobs > 0 ? round($total_nilai / $completed_jobs, 2) : 0;

		$completion_rate = $total_jobs ? ($completed_jobs / $total_jobs) * 100 : 0;
		$ontime_rate = $completed_jobs ? ($ontime_jobs / $completed_jobs) * 100 : 0;

		return [
			'total_jobs' => $total_jobs,
			'completed_jobs' => $completed_jobs,
			'pending_jobs' => $this->db->where('id_user', $id_user)->where('status', 'PENDING')->count_all_results('jobsheet'),
			'onprogress_jobs' => $this->db->where('id_user', $id_user)->where('status', 'ON PROGRESS')->count_all_results('jobsheet'),
			'completion_rate' => round($completion_rate, 2),
			'ontime_rate' => round($ontime_rate, 2),
			'average_nilai' => $average_nilai
		];
	}

	public function getRecentJobsheets($limit = 5)
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, finished_at) as days_left');
		$this->db->where('jobsheet.status', 'COMPLETED');
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->order_by('tasked_at', 'DESC');
		$this->db->limit($limit);
		return $this->db->get('jobsheet')->result_array();
	}

	public function getRevisedJobsheets()
	{
		$this->db->select('jobsheet.*, user.nama as revised_by_name, 
																					jobsheet_revisions.revised_at, jobsheet_revisions.revision_note,
																					jobsheet_revisions.revision_count,
																					jobsheet_revisions.karyawan_comment');
		$this->db->from('jobsheet');
		$this->db->join('jobsheet_revisions', 'jobsheet_revisions.id_jobsheet = jobsheet.id_jobsheet');
		$this->db->join('user', 'user.id_user = jobsheet_revisions.revised_by');
		$this->db->where('jobsheet.id_user', $this->session->userdata('id_user'));
		$this->db->where('jobsheet.is_revision', 1);
		$this->db->where('jobsheet.status', 'PENDING');
		$this->db->order_by('jobsheet_revisions.revised_at', 'DESC');
		return $this->db->get()->result_array();
	}

	public function getJobsheetRevisions($id_jobsheet)
	{
		$this->db->select('jobsheet_revisions.*, user.nama as revised_by_name');
		$this->db->from('jobsheet_revisions');
		$this->db->join('user', 'user.id_user = jobsheet_revisions.revised_by');
		$this->db->where('id_jobsheet', $id_jobsheet);
		$this->db->order_by('revised_at', 'DESC');
		return $this->db->get()->result_array();
	}

	// ------------------------------------------------------------------------

}

/* End of file Karyawan_model.php */
/* Location: ./application/models/Karyawan_model.php */
