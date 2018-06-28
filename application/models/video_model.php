<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_model extends Crud
{
	public $name_table = 'video';
	public $id_page = 'id';
	
	public function get($limit,$start_from,$access)
	{
		if($access=='isLogin')
		{
			
			$this->db->where_not_in('access', '3');
			
			
		}
		else
		{
			$this->db->where_in('access', '1');
		}
			$this->db->limit($limit,$start_from);
			$this->db->order_by('id','desc');
			$query = $this->db->get($this->name_table);
			return $query->result_array();
		
	}
	public function v_count_all($access)//Підрахунок відео для всіх чи для користувачів
	{
		if($access=='isLogin')
		{
			
			$this->db->where_not_in('access', '3');
				
			
		}
		else
		{
			
			$this->db->where_in('access', '1');
		}
		
		return $this->db->count_all_results($this->name_table);
	}
	public function get_grid($sidx,$sord,$start,$limit,$where)
	{
		if($where!='')$this->db->where($where,NULL,FALSE);
		$this->db->limit($limit,$start);
		$this->db->order_by($sidx,$sord); 	
		$query = $this->db->get('video');
		return $query->result_array();
	}
	public function count_grid($where)
	{
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	
}