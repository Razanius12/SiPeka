<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Home_model
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

class Home_model extends CI_Model
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

 public function getSystemStats()
 {
  return [
   'total_karyawan' => $this->db->where('role', 'Karyawan')->count_all_results('user'),
   'total_divisi' => $this->db->count_all_results('divisi'),
   'total_tasks' => $this->db->count_all_results('jobsheet'),
   'completed_tasks' => $this->db->where('status', 'COMPLETED')->count_all_results('jobsheet')
  ];
 }

 public function getTopPerformers($limit = 5)
 {
  $this->db->select('user.nama, divisi.nama_divisi,
				                 COUNT(jobsheet.id_jobsheet) as total_tasks,
				                 SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN 1 ELSE 0 END) as completed_tasks');
  $this->db->from('user');
  $this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
  $this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
  $this->db->where('user.role', 'Karyawan');
  $this->db->group_by('user.id_user');
  $this->db->order_by('completed_tasks', 'DESC');
  $this->db->limit($limit);
  return $this->db->get()->result_array();
 }

 public function getDivisionCompletionRates()
 {
  $this->db->select('divisi.nama_divisi, 
				                 COUNT(jobsheet.id_jobsheet) as total_tasks,
				                 SUM(CASE WHEN jobsheet.status = "COMPLETED" THEN 1 ELSE 0 END) as completed_tasks');
  $this->db->from('divisi');
  $this->db->join('user', 'divisi.id_divisi = user.id_divisi');
  $this->db->join('jobsheet', 'user.id_user = jobsheet.id_user');
  $this->db->group_by('divisi.id_divisi');
  return $this->db->get()->result_array();
 }

 public function getRecentActivities($limit = 5)
 {
  $this->db->select('jobsheet.title, user.nama, divisi.nama_divisi, jobsheet.finished_at');
  $this->db->from('jobsheet');
  $this->db->join('user', 'jobsheet.id_user = user.id_user');
  $this->db->join('divisi', 'user.id_divisi = divisi.id_divisi');
  $this->db->where('jobsheet.status', 'COMPLETED');
  $this->db->order_by('jobsheet.finished_at', 'DESC');
  $this->db->limit($limit);
  return $this->db->get()->result_array();
 }

 // ------------------------------------------------------------------------

}

/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */
