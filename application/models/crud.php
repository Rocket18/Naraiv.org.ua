<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Crud extends CI_Model
{
	public $name_table = '';
	public $id_page = '';
	
	public function __construct()
	{
		parent::__construct();
	}
	public function get($pages_id)
	{
		$this->db->where($this->id_page,$pages_id);
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function count_all()
	{
		return $this->db->count_all($this->name_table);
	}
	public function add($data)
	{
		$this->db->insert($this->name_table,$data);	
	}
		public function delete($id)
	{
		
	$this->db->delete($this->name_table, array('id' => $id));
	}
	public function update($data,$id)
	{
		$this->db->update($this->name_table, $data, array($this->id_page => $id));
	}
}