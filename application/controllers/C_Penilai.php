<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller C_Penilai
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

class C_Penilai extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Penilai_model');
	}

	public function index()
	{
		check_access(['Tim Penilai']);
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

	public function jobsheetPending()
	{
		check_access(['Tim Penilai']);
		$data['jobsheet'] = $this->Penilai_model->getAllPendingJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/jobsheetPending', $data);
		$this->load->view('templates/footer');
	}

	public function jobsheetOnProgress()
	{
		check_access(['Tim Penilai']);
		$data['jobsheet'] = $this->Penilai_model->getAllOnProgressJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/jobsheetOnProgress', $data);
		$this->load->view('templates/footer');
	}

	public function jobsheetCompleted()
	{
		check_access(['Tim Penilai']);
		$data['jobsheet'] = $this->Penilai_model->getAllCompletedJobsheet();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/jobsheetCompleted', $data);
		$this->load->view('templates/footer');
	}

	public function formTambahJobsheet()
	{
		check_access(['Tim Penilai']);
		$data['karyawan'] = $this->Penilai_model->getAllKaryawan();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/formTambahJobsheet', $data);
		$this->load->view('templates/footer');
	}

	public function tambahJobsheet()
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->tambahJobsheet();
		redirect(base_url() . 'C_Penilai/jobsheetPending?status=added');
	}

	public function formEditJobsheet($id)
	{
		check_access(['Tim Penilai']);
		$data['jobsheet'] = $this->Penilai_model->getJobsheetID($id);
		$data['karyawan'] = $this->Penilai_model->getAllKaryawan();
		$data['revisions'] = $this->Penilai_model->getJobsheetRevisions($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/formEditJobsheet', $data);
		$this->load->view('templates/footer');
	}

	public function formNilaiJobsheet($id)
	{
		check_access(['Tim Penilai']);
		$data['jobsheet'] = $this->Penilai_model->getJobsheetID($id);
		$data['karyawan'] = $this->Penilai_model->getAllKaryawan();
		$data['revisions'] = $this->Penilai_model->getJobsheetRevisions($id);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/formNilaiJobsheet', $data);
		$this->load->view('templates/footer');
	}

	public function updateNilaiJobsheet()
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->updateNilaiJobsheet();
		redirect(base_url() . 'C_Penilai/jobsheetCompleted?status=updated');
	}

	public function updateJobsheet()
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->updateJobsheet();
		if ($this->input->post('status') === 'PENDING') {
			redirect(base_url() . 'C_Penilai/jobsheetPending?status=updated');
		} else if ($this->input->post('status') === 'ON PROGRESS') {
			redirect(base_url() . 'C_Penilai/jobsheetOnProgress?status=updated');
		} else if ($this->input->post('status') === 'COMPLETED') {
			redirect(base_url() . 'C_Penilai/jobsheetCompleted?status=updated');
		} else {
			redirect(base_url() . 'C_Penilai');
		}
	}

	public function hapusJobsheet($id)
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->hapusJobsheet($id);
		if ($this->input->get('from') === 'pending') {
			redirect(base_url() . 'C_Penilai/jobsheetPending?status=deleted');
		} else if ($this->input->get('from') === 'onprogress') {
			redirect(base_url() . 'C_Penilai/jobsheetOnProgress?status=deleted');
		} else if ($this->input->get('from') === 'completed') {
			redirect(base_url() . 'C_Penilai/jobsheetCompleted?status=deleted');
		} else {
			redirect(base_url() . 'C_Penilai');
		}
	}

	public function deleteAttachment($jobsheet_id, $type, $file_index = null)
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->deleteJobsheetAttachment($jobsheet_id, $type, $file_index);
		redirect(base_url() . 'C_Penilai/formEditJobsheet/' . $jobsheet_id);
	}

	public function reviseJobsheet($id_jobsheet)
	{
		check_access(['Tim Penilai']);
		$this->Penilai_model->reviseJobsheet($id_jobsheet);
		redirect('C_Penilai/jobsheetPending?status=revisi');
	}

	public function penilaian()
	{
		check_access(['Tim Penilai', 'KepSek']);
		$selected_divisi = $this->input->get('divisi');
		$selected_periode = $this->input->get('periode');

		$data['divisi_list'] = $this->Penilai_model->getAllDivisi();
		$data['selected_divisi'] = $selected_divisi;
		$data['selected_periode'] = $selected_periode ?: 'all';

		$performance = $this->Penilai_model->getPerformanceStats($selected_divisi, $selected_periode);

		$performance_by_divisi = [];
		foreach ($performance as $p) {
			$divisi_name = $p['karyawan']['nama_divisi'];
			if (!isset($performance_by_divisi[$divisi_name])) {
				$performance_by_divisi[$divisi_name] = [];
			}
			$performance_by_divisi[$divisi_name][] = array_merge($p['karyawan'], $p);
		}
		$data['performance_by_divisi'] = $performance_by_divisi;

		$summary = [
			'total_karyawan' => count($performance),
			'avg_completion_rate' => 0,
			'total_active_tasks' => 0,
			'overdue_tasks' => 0
		];

		if (count($performance) > 0) {
			$total_completion_rate = 0;
			foreach ($performance as $p) {
				$total_completion_rate += $p['completion_rate'];
				$summary['total_active_tasks'] += ($p['onprogress_jobs'] + $p['pending_jobs']);
				$summary['overdue_tasks'] += isset($p['overdue_tasks']) ? $p['overdue_tasks'] : 0;
			}
			$summary['avg_completion_rate'] = round($total_completion_rate / count($performance));
		}

		$data['summary'] = $summary;

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/penilaian', $data);
		$this->load->view('templates/footer');
	}

	public function laporan()
	{
		check_access(['Tim Penilai', 'KepSek', 'Admin']);
		$data['divisi'] = $this->Penilai_model->getAllDivisi();
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('penilai/laporan', $data);
		$this->load->view('templates/footer');
	}

	public function generateLaporan()
	{
		check_access(['Tim Penilai', 'KepSek', 'Admin']);
		$this->load->library('pdfgenerator');

		$jenis_laporan = $this->input->post('jenis_laporan');
		$tahun = $this->input->post('tahun');
		$divisi = $this->input->post('divisi');

		if ($jenis_laporan == 'bulanan') {
			$periode = $this->input->post('bulan');
		} else if ($jenis_laporan == 'semester') {
			$periode = $this->input->post('semester');
		} else {
			$periode = null;
		}

		$data['jenis_laporan'] = $jenis_laporan;
		$data['tahun'] = $tahun;
		$data['periode'] = $periode;
		$data['divisi_name'] = '';

		if ($divisi) {
			$div = $this->db->get_where('divisi', ['id_divisi' => $divisi])->row();
			$data['divisi_name'] = $div->nama_divisi;
		}

		$data['kinerja'] = $this->Penilai_model->getLaporanPeriode($jenis_laporan, $tahun, $periode, $divisi);
		$data['detail_tugas'] = $this->Penilai_model->getDetailTugas($jenis_laporan, $tahun, $periode, $divisi);

		$file_pdf = 'Laporan_Penilaian_' . date('Y-m-d_H-i-s');
		$paper = 'A4';
		$orientation = "landscape";

		$html = $this->load->view('penilai/laporan_pdf', $data, true);
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}
}


/* End of file C_Penilai.php */
/* Location: ./application/controllers/C_Penilai.php */
