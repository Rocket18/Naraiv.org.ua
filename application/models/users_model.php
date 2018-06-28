<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
class Users_model extends Crud
{
	public $name_table = 'users_auth';
	public $id_page = 'id_user';
	
	public function get_by($email)
	{
		$this->db->where('email',$email);	
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function add_user($data)
	{
		$this->db->insert('users_auth',$data);
	}
	public function get_email($id)
	{
		$this->db->select('email,confirm_code');
		$this->db->where('id_user',$id);	
		$query = $this->db->get($this->name_table);
		return $query->row_array();	
	}
		public function get_pass($id)
	{
		$this->db->select('pass');
		$this->db->where('id_user',$id);	
		$query = $this->db->get($this->name_table);
		return $query->row_array();	
	}
	public function add_inf($data)
	{
		$this->db->insert('users_info',$data);
	}
	public function check_confirm_code($confirm_code)
	{
		$this->db->where('confirm_code',$confirm_code);	
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function update_stutus($confirm_code,$data)
	{
		$this->db->where('confirm_code',$confirm_code);
		$this->db->update($this->name_table,$data);
	}
	public function recover($id,$data)
	{
		$this->db->where($this->id_page,$id);
		$this->db->update($this->name_table,$data);
	}
	public function get_user($id)
	{
		$this->db->from($this->name_table);
		$this->db->join('users_info', 'users_auth.id_user = users_info.id_user','left');
		$this->db->where('users_auth.id_user',$id);
		$result = $this->db->get();	
		return $result->row_array();
	}
	public function get_grid($sidx,$sord,$start,$limit,$where)
	{
		$this->db->from($this->name_table);
		$this->db->limit($limit,$start);
		//$this->db->order_by($sidx,$sord); 
		if($where!='')$this->db->where($where,NULL,FALSE);
		$this->db->join('users_info', 'users_auth.id_user = users_info.id_user','left');
		$result = $this->db->get();	
		return $result->result_array();
	}
	public function advert()
	{
		$this->db->order_by('id','desc');
		$query = $this->db->get('advertising');
		return $query->result_array();
		
	}
	public function insert($table,$data)
	{
		$this->db->insert($table,$data);	
		
	}
	public function count_grid($where)
	{
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	public function update_info($data,$id)
	{
		$this->db->update('users_info', $data, array($this->id_page => $id));
	}
	
}