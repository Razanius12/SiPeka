<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Penilai_model
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

class Penilai_model extends CI_Model
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

	public function getAllKaryawan()
	{
		$this->db->select('user.*, divisi.nama_divisi');
		$this->db->from('user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
		$this->db->where('user.role', 'Karyawan');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllPendingJobsheet()
	{
		$this->db->select('jobsheet.*, user.nama, DATEDIFF(jobsheet.deadline, CURDATE()) as days_left');
		$this->db->from('jobsheet');
		$this->db->join('user', 'jobsheet.id_user = user.id_user');
		$this->db->where('jobsheet.status', 'PENDING');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllOnProgressJobsheet()
	{
		$this->db->select('jobsheet.*, user.nama, DATEDIFF(jobsheet.deadline, CURDATE()) as days_left');
		$this->db->from('jobsheet');
		$this->db->join('user', 'jobsheet.id_user = user.id_user');
		$this->db->where('jobsheet.status', 'ON PROGRESS');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllCompletedJobsheet()
	{
		$this->db->select('jobsheet.*, user.nama, DATEDIFF(jobsheet.deadline, finished_at) as days_left');
		$this->db->from('jobsheet');
		$this->db->join('user', 'jobsheet.id_user = user.id_user');
		$this->db->where('jobsheet.status', 'COMPLETED');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllDivisi()
	{
		$query = $this->db->get('divisi');
		return $query->result_array();
	}

	public function tambahJobsheet()
	{
		$attachment_id = null;
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

			$attachment_id = $this->uploadAttachments($files);
		}

		$data = [
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'tasked_at' => $this->input->post('tasked_at'),
			'deadline' => $this->input->post('deadline'),
			'id_user' => $this->input->post('id_user'),
			'references_id' => $attachment_id
		];

		return $this->db->insert('jobsheet', $data);
	}

	public function getJobsheetID($id)
	{
		return $this->db->get_where('jobsheet', ['id_jobsheet' => $id])->row_array();
	}

	public function updateJobsheet()
	{
		$data = [
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'tasked_at' => $this->input->post('tasked_at'),
			'deadline' => $this->input->post('deadline'),
			'status' => $this->input->post('status'),
			'id_user' => $this->input->post('id_user')
		];

		if (isset($_FILES['new_attachments']) && !empty($_FILES['new_attachments']['name'][0])) {
			if ($this->input->post('references_id')) {
				$new_attachment_id = $this->updateAttachments($_FILES['new_attachments'], $this->input->post('references_id'));
			} else {
				$new_attachment_id = $this->uploadAttachments($_FILES['new_attachments']);
			}
			$data['references_id'] = $new_attachment_id;
		}

		$this->db->where('id_jobsheet', $this->input->post('id_jobsheet'));
		$this->db->update('jobsheet', $data);
	}

	public function updateNilaiJobsheet()
	{
		$data = [
			'nilai' => $this->input->post('nilai')
		];

		$this->db->where('id_jobsheet', $this->input->post('id_jobsheet'));
		return $this->db->update('jobsheet', $data);
	}

	public function hapusJobsheet($id)
	{
		$jobsheet = $this->getJobsheetID($id);

		if ($jobsheet['references_id']) {
			$ref_attachments = $this->getAttachments($jobsheet['references_id']);

			for ($i = 1; $i <= 5; $i++) {
				$field = 'atch' . $i;
				if (!empty($ref_attachments[$field])) {
					$file_path = './uploads/jobsheet/' . $ref_attachments[$field];
					if (file_exists($file_path)) {
						unlink($file_path);
					}
				}
			}

			$this->db->where('id_jobsheet', $id);
			$this->db->update('jobsheet', ['references_id' => NULL]);

			$this->db->where('id_attachment', $jobsheet['references_id']);
			$this->db->delete('attachments');
		}

		if ($jobsheet['attach_result_id']) {
			$result_attachments = $this->getAttachments($jobsheet['attach_result_id']);

			$this->db->where('previous_result_id', $jobsheet['attach_result_id']);
			$this->db->update('jobsheet_revisions', ['previous_result_id' => NULL]);

			for ($i = 1; $i <= 5; $i++) {
				$field = 'atch' . $i;
				if (!empty($result_attachments[$field])) {
					$file_path = './uploads/jobsheet/' . $result_attachments[$field];
					if (file_exists($file_path)) {
						unlink($file_path);
					}
				}
			}

			$this->db->where('id_jobsheet', $id);
			$this->db->update('jobsheet', ['attach_result_id' => NULL]);

			$this->db->where('id_attachment', $jobsheet['attach_result_id']);
			$this->db->delete('attachments');
		}

		$this->db->where('id_jobsheet', $id);
		$this->db->delete('jobsheet_revisions');

		$this->db->where('id_jobsheet', $id);
		$this->db->delete('jobsheet');
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

	public function getAttachments($id)
	{
		return $this->db->get_where('attachments', ['id_attachment' => $id])->row_array();
	}

	public function updateAttachments($files, $attachment_id)
	{
		if (!isset($files['name']) || !is_array($files['name'])) {
			return $attachment_id;
		}

		$attachments = $this->getAttachments($attachment_id);
		if (!$attachments) {
			return $this->uploadAttachments($files);
		}

		$upload_path = './uploads/jobsheet/';

		$next_slot = 1;
		for ($i = 1; $i <= 5; $i++) {
			if (empty($attachments['atch' . $i])) {
				$next_slot = $i;
				break;
			}
		}

		$data = array();
		for ($i = 0; $i < min(count($files['name']), 5 - $next_slot + 1); $i++) {
			if (!empty($files['name'][$i])) {

				if (move_uploaded_file($files['tmp_name'][$i], $upload_path . $files['name'][$i])) {
					$data['atch' . ($i + 1)] = $files['name'][$i];
				}
			}
		}

		if (!empty($data)) {
			$this->db->where('id_attachment', $attachment_id);
			$this->db->update('attachments', $data);
		}

		return $attachment_id;
	}

	public function deleteJobsheetAttachment($jobsheet_id, $type, $file_index = null)
	{
		$jobsheet = $this->getJobsheetID($jobsheet_id);
		$field = $type . '_id';  // references_id or attach_result_id

		if ($jobsheet[$field]) {
			$attachments = $this->getAttachments($jobsheet[$field]);

			if ($file_index !== null) {
				$atch_field = 'atch' . ($file_index + 1);
				if (!empty($attachments[$atch_field])) {
					$file_path = './uploads/jobsheet/' . $attachments[$atch_field];
					if (file_exists($file_path)) {
						unlink($file_path);
					}

					$this->db->where('id_attachment', $jobsheet[$field]);
					$this->db->update('attachments', [$atch_field => '']);

					$empty = true;
					for ($i = 1; $i <= 5; $i++) {
						if (!empty($attachments['atch' . $i])) {
							$empty = false;
							break;
						}
					}

					if ($empty) {
						$this->db->where('id_jobsheet', $jobsheet_id);
						$this->db->update('jobsheet', [$field => null]);

						$this->db->where('id_attachment', $jobsheet[$field]);
						$this->db->delete('attachments');
					}
				}
			} else {
				$this->db->where('id_jobsheet', $jobsheet_id);
				$this->db->update('jobsheet', [$field => null]);

				$upload_path = './uploads/jobsheet/';
				for ($i = 1; $i <= 5; $i++) {
					$atch_field = 'atch' . $i;
					if (!empty($attachments[$atch_field])) {
						$file_path = $upload_path . $attachments[$atch_field];
						if (file_exists($file_path)) {
							unlink($file_path);
						}
					}
				}

				$this->db->where('id_attachment', $jobsheet[$field]);
				$this->db->delete('attachments');
			}

			return true;
		}
		return false;
	}

	public function calculateRevisionScore($revision_count)
	{
		// Base score is 100, deduct 10 points for each revision
		$score = 100 - ($revision_count * 10);
		// Ensure score doesn't go below 0
		return max(0, $score);
	}

	public function getPerformanceStats($divisi = null, $periode = 'all')
	{
		$this->db->select('user.*, divisi.nama_divisi');
		$this->db->from('user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
		$this->db->where('user.role', 'Karyawan');

		if ($divisi) {
			$this->db->where('user.id_divisi', $divisi);
		}

		$this->db->order_by('divisi.nama_divisi', 'ASC');
		$karyawan = $this->db->get()->result_array();

		$stats = [];
		foreach ($karyawan as $k) {
			$this->db->select('COUNT(id_jobsheet) as total_jobs, 
																								COUNT(CASE WHEN status = "COMPLETED" THEN 1 END) as completed_jobs,
																								COUNT(CASE WHEN status = "PENDING" THEN 1 END) as pending_jobs,
																								COUNT(CASE WHEN status = "ON PROGRESS" THEN 1 END) as progress_jobs,
																								COUNT(CASE WHEN status = "COMPLETED" AND finished_at <= deadline THEN 1 END) as ontime_jobs,
																								COALESCE(AVG(CASE WHEN status = "COMPLETED" THEN nilai END), 0) as average_nilai,
                        COALESCE(AVG(CASE WHEN status = "COMPLETED" THEN (100 - (current_revision * 10)) END), 0) as average_revision_score');
			$this->db->from('jobsheet');
			$this->db->where('id_user', $k['id_user']);

			if ($periode == 'month') {
				$this->db->where('MONTH(tasked_at)', date('m'));
				$this->db->where('YEAR(tasked_at)', date('Y'));
			} else if ($periode == 'semester') {
				$current_month = date('m');
				if ($current_month <= 6) {
					$this->db->where('MONTH(tasked_at) <=', 6);
				} else {
					$this->db->where('MONTH(tasked_at) >', 6);
				}
				$this->db->where('YEAR(tasked_at)', date('Y'));
			} else if ($periode == 'year') {
				$this->db->where('YEAR(tasked_at)', date('Y'));
			}

			$job_stats = $this->db->get()->row_array();

			$total_jobs = $job_stats['total_jobs'];
			$completed_jobs = $job_stats['completed_jobs'];
			$ontime_rate = $completed_jobs ? round(($job_stats['ontime_jobs'] / $completed_jobs) * 100, 2) : 0;
			$average_nilai = round($job_stats['average_nilai'], 2);
			$average_revision_score = round($job_stats['average_revision_score'], 2);
			$total_nilai = round(($ontime_rate + $average_nilai + $average_revision_score) / 3, 2);

			$stats[] = [
				'karyawan' => $k,
				'total_jobs' => $total_jobs,
				'completed_jobs' => $completed_jobs,
				'pending_jobs' => $job_stats['pending_jobs'],
				'onprogress_jobs' => $job_stats['progress_jobs'],
				'completion_rate' => $total_jobs ? round(($completed_jobs / $total_jobs) * 100, 2) : 0,
				'ontime_rate' => $ontime_rate,
				'average_nilai' => $average_nilai,
				'average_revision_score' => $average_revision_score,
				'total_nilai' => $total_nilai,
				'overdue_tasks' => $this->getOverdueTasks($k['id_user'], $periode)
			];
		}

		return $stats;
	}

	private function applyPeriodFilter($periode)
	{
		if ($periode == 'month') {
			$this->db->where('MONTH(tasked_at)', date('m'));
			$this->db->where('YEAR(tasked_at)', date('Y'));
		} else if ($periode == 'semester') {
			$current_month = date('m');
			if ($current_month <= 6) {
				$this->db->where('MONTH(tasked_at) <=', 6);
			} else {
				$this->db->where('MONTH(tasked_at) >', 6);
			}
			$this->db->where('YEAR(tasked_at)', date('Y'));
		} else if ($periode == 'year') {
			$this->db->where('YEAR(tasked_at)', date('Y'));
		}
	}

	private function getStatusCount($user_id, $status, $periode)
	{
		$this->db->where('id_user', $user_id)
			->where('status', $status);
		if ($periode != 'all') {
			$this->applyPeriodFilter($periode);
		}
		return $this->db->count_all_results('jobsheet');
	}

	private function getOverdueTasks($user_id, $periode)
	{
		$this->db->where('id_user', $user_id)
			->where('deadline <', date('Y-m-d H:i:s'))
			->where_in('status', ['PENDING', 'ON PROGRESS']);
		if ($periode != 'all') {
			$this->applyPeriodFilter($periode);
		}
		return $this->db->count_all_results('jobsheet');
	}

	public function getRecentJobsheets($limit = 5)
	{
		$this->db->select('jobsheet.*, DATEDIFF(jobsheet.deadline, finished_at) as days_left');
		$this->db->where('jobsheet.status', 'COMPLETED');
		$this->db->order_by('tasked_at', 'DESC');
		$this->db->limit($limit);
		return $this->db->get('jobsheet')->result_array();
	}

	public function getLaporanPeriode($jenis_laporan, $tahun, $periode, $divisi = null)
	{
		$this->db->select('user.*, divisi.nama_divisi, 
				               		COUNT(jobsheet.id_jobsheet) as total_tugas,
						             		SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN 1 ELSE 0 END) as tugas_selesai,
						             		SUM(CASE WHEN jobsheet.status = "PENDING" THEN 1 ELSE 0 END) as tugas_pending,
						             		SUM(CASE WHEN jobsheet.status = "ON PROGRESS" THEN 1 ELSE 0 END) as tugas_progress,
						             		SUM(CASE WHEN jobsheet.status = "COMPLETED" AND jobsheet.finished_at <= jobsheet.deadline THEN 1 ELSE 0 END) as tepat_waktu,
																					SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN jobsheet.nilai ELSE 0 END) as total_nilai,
                     SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN (100 - (jobsheet.current_revision * 10)) ELSE 0 END) as total_revision_score');

		$this->db->from('user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
		$this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
		$this->db->where('user.role', 'Karyawan');
		$this->db->where('YEAR(jobsheet.tasked_at)', $tahun);

		if ($divisi) {
			$this->db->where('user.id_divisi', $divisi);
		}

		if ($jenis_laporan == 'bulanan') {
			$this->db->where('MONTH(jobsheet.tasked_at)', $periode);
		} else if ($jenis_laporan == 'semester') {
			if ($periode == 1) {
				$this->db->where('MONTH(jobsheet.tasked_at) <=', 6);
			} else {
				$this->db->where('MONTH(jobsheet.tasked_at) >', 6);
			}
		}

		$this->db->group_by('user.id_user');
		$this->db->order_by('divisi.nama_divisi', 'ASC');

		return $this->db->get()->result_array();
	}

	public function getDetailTugas($jenis_laporan, $tahun, $periode, $divisi = null)
	{
		$this->db->select('jobsheet.*, user.nama, divisi.nama_divisi');
		$this->db->from('jobsheet');
		$this->db->join('user', 'jobsheet.id_user = user.id_user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
		$this->db->where('YEAR(jobsheet.tasked_at)', $tahun);

		if ($divisi) {
			$this->db->where('user.id_divisi', $divisi);
		}

		if ($jenis_laporan == 'bulanan') {
			$this->db->where('MONTH(jobsheet.tasked_at)', $periode);
		} else if ($jenis_laporan == 'semester') {
			if ($periode == 1) {
				$this->db->where('MONTH(jobsheet.tasked_at) <=', 6);
			} else {
				$this->db->where('MONTH(jobsheet.tasked_at) >', 6);
			}
		}

		$this->db->order_by('jobsheet.tasked_at', 'DESC');
		return $this->db->get()->result_array();
	}

	public function getDivisiPerformance()
	{
		$this->db->select('divisi.nama_divisi as divisi, 
                     COUNT(DISTINCT user.id_user) as total_karyawan,
                     COUNT(jobsheet.id_jobsheet) as total_tasks,
                     SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN 1 ELSE 0 END) as completed_tasks');
		$this->db->from('divisi');
		$this->db->join('user', 'divisi.id_divisi = user.id_divisi');
		$this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
		$this->db->where('MONTH(jobsheet.tasked_at)', date('m'));
		$this->db->where('YEAR(jobsheet.tasked_at)', date('Y'));
		$this->db->group_by('divisi.id_divisi');

		$result = $this->db->get()->result_array();

		foreach ($result as &$row) {
			$row['completion_rate'] = $row['total_tasks'] ?
				round(($row['completed_tasks'] / $row['total_tasks']) * 100) : 0;
		}

		return $result;
	}

	public function getRecentActivities()
	{
		$this->db->select('jobsheet.*, user.nama, "fa-check" as icon');
		$this->db->from('jobsheet');
		$this->db->join('user', 'jobsheet.id_user = user.id_user');
		$this->db->where('status', 'COMPLETED');
		$this->db->order_by('finished_at', 'DESC');
		$this->db->limit(5);

		$activities = [];
		foreach ($this->db->get()->result_array() as $row) {
			$activities[] = [
				'date' => $row['finished_at'],
				'icon' => 'fa-check',
				'title' => $row['nama'] . ' menyelesaikan tugas',
				'description' => $row['title']
			];
		}

		return $activities;
	}

	public function getTasksByDivision()
	{
		$this->db->select('divisi.nama_divisi,
                     COUNT(jobsheet.id_jobsheet) as total,
                     SUM(CASE WHEN status = "COMPLETED" THEN 1 ELSE 0 END) as completed,
                     SUM(CASE WHEN status = "ON PROGRESS" THEN 1 ELSE 0 END) as progress,
                     SUM(CASE WHEN status = "PENDING" THEN 1 ELSE 0 END) as pending');
		$this->db->from('divisi');
		$this->db->join('user', 'divisi.id_divisi = user.id_divisi');
		$this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
		$this->db->where('MONTH(jobsheet.tasked_at)', date('m'));
		$this->db->where('YEAR(jobsheet.tasked_at)', date('Y'));
		$this->db->group_by('divisi.id_divisi');

		return $this->db->get()->result_array();
	}

	public function getTopPerformers()
	{
		$this->db->select('user.nama, 
																					divisi.nama_divisi as divisi,
																					COUNT(jobsheet.id_jobsheet) as total_tasks,
																					SUM(CASE WHEN status = "COMPLETED" THEN 1 ELSE 0 END) as completed_tasks,
																					(SUM(CASE WHEN status = "COMPLETED" THEN 1 ELSE 0 END) / COUNT(jobsheet.id_jobsheet) * 100) as completion_rate');
		$this->db->from('user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
		$this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
		$this->db->where('MONTH(jobsheet.tasked_at)', date('m'));
		$this->db->where('YEAR(jobsheet.tasked_at)', date('Y'));
		$this->db->group_by('user.id_user');
		$this->db->having('total_tasks > 0');
		$this->db->order_by('completion_rate', 'DESC');
		$this->db->limit(4);

		$result = $this->db->get()->result_array();

		foreach ($result as &$row) {
			$row['completion_rate'] = round($row['completion_rate']);
		}

		return $result;
	}

	public function reviseJobsheet($id_jobsheet)
	{

		$jobsheet = $this->getJobsheetID($id_jobsheet);

		$revision_data = [
			'id_jobsheet' => $id_jobsheet,
			'revision_count' => $jobsheet['current_revision'] + 1,
			'previous_status' => $jobsheet['status'],
			'revised_by' => $this->session->userdata('id_user'),
			'revision_note' => $this->input->post('revision_note'),
			'previous_result_id' => $jobsheet['attach_result_id']
		];

		$this->db->insert('jobsheet_revisions', $revision_data);
		$revision_id = $this->db->insert_id();

		if ($jobsheet['attach_result_id']) {
			$attachments = $this->getAttachments($jobsheet['attach_result_id']);

			$this->db->where('id_jobsheet', $id_jobsheet);
			$this->db->update('jobsheet', ['attach_result_id' => NULL]);

			$this->db->where('id_revision', $revision_id);
			$this->db->update('jobsheet_revisions', ['previous_result_id' => NULL]);

			for ($i = 1; $i <= 5; $i++) {
				$field = 'atch' . $i;
				if (!empty($attachments[$field])) {
					$file_path = './uploads/jobsheet/' . $attachments[$field];
					if (file_exists($file_path)) {
						unlink($file_path);
					}
				}
			}

			$this->db->where('id_attachment', $jobsheet['attach_result_id']);
			$this->db->delete('attachments');
		}

		$data = [
			'status' => 'PENDING',
			'current_revision' => $jobsheet['current_revision'] + 1,
			'is_revision' => 1,
			'finished_at' => null,
			'deadline' => $this->input->post('new_deadline')
		];

		$this->db->where('id_jobsheet', $id_jobsheet);
		$this->db->update('jobsheet', $data);
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

/* End of file Penilai_model.php */
/* Location: ./application/models/Penilai_model.php */
