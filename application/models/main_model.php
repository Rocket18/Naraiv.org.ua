<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends Crud
{
	public $name_table = 'menu';
	public $id_page = 'menu_id';

	public function getMenu($admin)
	{
		$this->db->select('id,menu_id,parent_id,new,name');
		if($admin=='')
			$this->db->where('leftMenu',1);
		$query = $this->db->get($this->name_table);
		return $query->result_array();
	}
	public function getInfNews()
	{	
		$this->db->where('menu_id','news');
		$this->db->select('title,description,keywords');
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function get_title()
	{
		$this->db->select('title');
		$this->db->from('menu');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function getwhereTable($table,$sidx,$sord,$start,$limit,$where)
	{
		$this->db->limit($limit,$start);
		$this->db->order_by($sidx,$sord); 
		if($where!='')$this->db->where($where,NULL,FALSE);
		$result = $this->db->get($table);	
		return $result->result_array();
	}
	public function countTable($table)
	{
		return $this->db->count_all($table);
	}
	public function lessons($school)
	{	 	
		$query = $this->db->get('less_'.$school);
		return $query->result_array();	
	}
	public function insertS($data,$les)
	{
		$this->db->insert('less_'.$les,$data);
	}
	public function updateS($class,$data,$les)
	{
		$this->db->update('less_'.$les, $data, array('class' => $class));
	}
	public function getFilm($year,$where)
	{
		$this->db->select('name');
		$this->db->where('year',$year);
		$this->db->or_where($where);
		$result = $this->db->get('movies');	
		return $result->result_array();
	}
	public function updateMain($table,$data,$id)
	{
		$this->db->update($table, $data, array('id' => $id));
	}
	public function insertMain($table,$data)
	{
		$this->db->insert($table,$data);	
	}
	public function deleteMain($table,$id)
	{
		$this->db->delete($table, array('id' => $id)); 	
	}
	public function count_grid($where)
	{
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
		public function prognoz($id)
	{
		$this->db->select('prognoz');
		$this->db->where('id',$id);
		$query = $this->db->get('prevision');
		return $query->row_array();
	}
}