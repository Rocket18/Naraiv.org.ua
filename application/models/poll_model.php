<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Poll_model extends Crud 
{
	public $name_table = 'polls';
	public $id_page = 'id';
	public function get_id()
	{
		$this->db->select('id,ip');
		$this->db->where('status', 'active');
		$query = $this->db->get($this->name_table);
		return $query->row();	
	}
	public function get_poll()//Отримання форми голосування
	{
		$this->db->select('id, question, answers,ip');
		$this->db->where('status', 'active');
		$query = $this->db->get($this->name_table);
		return $query->row();
	}
	public function getPoll($id)//Отримання назви та варіантів відповідей
	{
		$this->db->select('question, answers');
		$this->db->where('id', $id);
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function set_poll()
	{
		$this->db->select('id,answers, votes,ip');
		$this->db->where('status', 'active');
		$query = $this->db->get($this->name_table);
		return $query->row();
		
	}
	public function get_result()
	{
		$this->db->select('question, answers, votes');
		$this->db->where('status', 'active');
		$query = $this->db->get('polls');
		return $query->row();	
	}
	public function updates($data)
	{
		$this->db->update($this->name_table, $data , array('status' => 'active'));
		
	}
	public function get_grid($sidx,$sord,$start,$limit,$where)
	{
		$this->db->select('id, question, status,data');
		if($where!='')$this->db->where($where,NULL,FALSE);
		$this->db->limit($limit,$start);
		$this->db->order_by($sidx,$sord); 	
		$query = $this->db->get($this->name_table);
		return $query->result_array();
		
						     
	}
	public function active($data,$id)
	{
		$row = array('status'=>'inactive');
		$this->db->where('status','active');
		$this->db->update($this->name_table,$row);
		$this->db->update($this->name_table, $data, array($this->id_page => $id));	
	}
	public function count_grid($where)
	{
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	public function resets($id)
	{
		$this->db->where('id',$id);
		$data = array('votes'=>'');
		$this->db->update($this->name_table,$data);
			
	}
	
}