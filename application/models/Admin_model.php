<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
	*
	* Model Admin_model
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

class Admin_model extends CI_Model
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

	public function getAllDivisi()
	{
		$query = $this->db->get('divisi');
		return $query->result_array();
	}

	public function tambahDivisi()
	{
		$data = [
			'nama_divisi' => $this->input->post('nama_divisi')
		];
		$this->db->insert('divisi', $data);
	}

	public function getDivisiID($id)
	{
		return $this->db->get_where('divisi', ['id_divisi' => $id])->row_array();
	}

	public function updateDivisi()
	{
		$data = [
			'nama_divisi' => $this->input->post('nama_divisi')
		];
		$this->db->where('id_divisi', $this->input->post('id_divisi'));
		$this->db->update('divisi', $data);
	}

	public function hapusDivisi($id)
	{
		$this->db->where('id_divisi', $id);
		$this->db->delete('divisi');
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

	public function tambahKaryawan()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'nama' => $this->input->post('nama'),
			'no_telp' => $this->input->post('no_telp'),
			'role' => 'Karyawan',
			'id_divisi' => $this->input->post('id_divisi')
		];
		$this->db->insert('user', $data);
	}

	public function getKaryawanID($id)
	{
		return $this->db->get_where('user', ['id_user' => $id])->row_array();
	}

	public function updateKaryawan()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'nama' => $this->input->post('nama'),
			'no_telp' => $this->input->post('no_telp'),
			'role' => 'Karyawan',
			'id_divisi' => $this->input->post('id_divisi')
		];
		$this->db->where('id_user', $this->input->post('id_user'));
		$this->db->update('user', $data);
	}

	public function hapusKaryawan($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete('user');
	}

	public function getAllPenilai()
	{
		return $this->db->get_where('user', ['role' => 'Tim Penilai'])->result_array();
	}

	public function tambahPenilai()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'nama' => $this->input->post('nama'),
			'no_telp' => $this->input->post('no_telp'),
			'role' => 'Tim Penilai'
		];
		$this->db->insert('user', $data);
	}

	public function getPenilaiID($id)
	{
		return $this->db->get_where('user', ['id_user' => $id])->row_array();
	}

	public function updatePenilai()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'nama' => $this->input->post('nama'),
			'no_telp' => $this->input->post('no_telp'),
			'role' => 'Tim Penilai'
		];
		$this->db->where('id_user', $this->input->post('id_user'));
		$this->db->update('user', $data);
	}

	public function hapusPenilai($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete('user');
	}

	public function getDashboardStats()
	{
		return [
			'total_karyawan' => $this->db->where('role', 'Karyawan')->count_all_results('user'),
			'total_divisi' => $this->db->count_all_results('divisi'),
			'total_penilai' => $this->db->where('role', 'Tim Penilai')->count_all_results('user'),
			'total_jobsheet' => $this->db->count_all_results('jobsheet')
		];
	}

	public function getDivisiData()
	{
		$this->db->select('divisi.nama_divisi, COUNT(user.id_user) as jumlah_karyawan');
		$this->db->from('divisi');
		$this->db->join('user', 'divisi.id_divisi = user.id_divisi', 'left');
		$this->db->where('user.role', 'Karyawan');
		$this->db->group_by('divisi.id_divisi');
		return $this->db->get()->result_array();
	}

	public function getDivisiSummary()
	{
		$this->db->select('
                     divisi.nama_divisi,
                     COUNT(DISTINCT user.id_user) as jumlah_karyawan,
                     COUNT(jobsheet.id_jobsheet) as total_jobsheet,
                     SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN 1 ELSE 0 END) as completed_jobsheet,
                     SUM(CASE WHEN jobsheet.status IN ("PENDING", "ON PROGRESS") THEN 1 ELSE 0 END) as ongoing_jobsheet
    ');
		$this->db->from('divisi');
		$this->db->join('user', 'divisi.id_divisi = user.id_divisi');
		$this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
		$this->db->where('user.role', 'Karyawan');
		$this->db->group_by('divisi.id_divisi');

		$result = $this->db->get()->result_array();

		foreach ($result as &$row) {
			$row['completion_rate'] = $row['total_jobsheet'] > 0 ?
				round(($row['completed_jobsheet'] / $row['total_jobsheet']) * 100) : 0;
		}

		return $result;
	}

	public function getUserID($id)
	{
		return $this->db->get_where('user', ['id_user' => $id])->row_array();
	}

	public function updateUser()
	{
		$data = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'nama' => $this->input->post('nama'),
			'no_telp' => $this->input->post('no_telp'),
			'role' => $this->input->post('role')
		];
		
		$this->db->where('id_user', $this->input->post('id_user'));
		$this->db->update('user', $data);
	}

	// ------------------------------------------------------------------------

}

/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */
