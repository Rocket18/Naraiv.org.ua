<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_model extends Crud
{
	public $name_table = 'photo';
	public $id_page = 'id';
	public function get2()
	{
		$query = $this->db->get('photo');
		return $query->result_array();	
	}
	public function get_photo($limit,$start_from,$id,$cat)//Отримання фото для всіх
	{
		if($id=='')
		{
			$access = array(1,2);
			$this->db->where_not_in('access', $access);
			
			if($cat!='')$this->db->where('cat',$cat);
		}
		else
		{
			
			if($cat!='')
			{
				$this->db->where_not_in('access', '2');
				$array = array('author'=>$id,'cat'=>$cat);
				$this->db->where($array);
			}
			else
				$this->db->where('author',$id);
		}
		
		$this->db->limit($limit,$start_from);
		$this->db->order_by('id','desc');
		$query = $this->db->get($this->name_table);
		return $query->result_array();
	}
	public function count_all($id,$cat)//Підрахунок фото для всіх чи для користувачів
	{
		if($id=='')
		{
			$access = array(1,2);
			$this->db->where_not_in('access', $access);
				
			if($cat!='')$this->db->where('cat',$cat);
		}
		else
		{
			$this->db->where_not_in('access', 2);
			if($cat!='')
			{
				$array = array('author'=>$id,'cat'=>$cat);
				$this->db->where($array);
			}
			else
				$this->db->where('author',$id);
		}
		
		return $this->db->count_all_results($this->name_table);
	}
	public function all_count()//Підрахунок фото всіх
	{
		
		return $this->db->count_all($this->name_table);
	}
	public function get_src($id)//Підрахунок фото всіх
	{
		
		$this->db->select('photo_src');
		$this->db->where($this->id_page,$id);
		$query = $this->db->get($this->name_table);
		return $query->row_array();
	}
	public function count_where($id)//Підрахунок доданих користувачем
	{
		$array = array('author' => $id);
		$this->db->where($array); 
		$this->db->from($this->name_table);
		return $this->db->count_all_results();
	}
	public function get_grid($sidx,$sord,$start,$limit,$where,$id='')
	{
		$this->db->from($this->name_table);
		if($where!='')$this->db->where($where,NULL,FALSE);
		$this->db->limit($limit,$start);
		$this->db->order_by($sidx,$sord); 
		if($id!='')$this->db->where('author',$id);else
		$this->db->join('users_info', 'users_info.id_user = photo.author','left');		
		$query = $this->db->get();
		return $query->result_array();	
	}
	public function count_grid($where)
	{
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	public function delete_user($file)
	{
		$this->db->where('photo_src',$file);
		$this->db->delete($this->name_table);
		
	}
	
}