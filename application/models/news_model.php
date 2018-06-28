<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends Crud
{
	public $name_table = 'news';
	public $id_page = 'news_id';
	public function get($id)//Отримання  новини за id(публіковані)
	{
		$this->db->from($this->name_table);
		$array = array($this->id_page => $id,'publish'=>'1','data <' => date('Y-m-d H:i:s'));
		$this->db->where($array);
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->row_array();
	}
	public function get2($id)//Отримання  новини за id(непубліковані)
	{
		$this->db->from($this->name_table);
		$array = array($this->id_page => $id,'publish'=>'0');
		$this->db->where($array);
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->row_array();
	}
	public function news_where_user($id,$id_user)//Отримання новини за id певного користувача
	{
		$this->db->from($this->name_table);
		$array = array('news_id' => $id,'author'=>$id_user);
		$this->db->where($array); 
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->row_array();
	}
	public function news_user($limit,$start_from,$id)//Всі новини додані певним користувачем
	{
		$this->db->from($this->name_table);
		$this->db->order_by('data','desc');
		$array = array('author' => $id);
		$this->db->where($array); 
		$this->db->limit($limit,$start_from);	
		$this->db->join('users_info', 'users_info.id_user = news.author','left');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function last_news()//5 останніх новин
	{
		$this->db->select('news_id,title_news');
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		$this->db->order_by('data','desc');
		$this->db->limit(5);	
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get($this->name_table);
		return $query->result_array();
	}
	public function popular_news()//5 найбільш популярних 
	{
		$this->db->select('news_id,title_news');
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		$this->db->order_by('views','desc');
		$this->db->limit(5);	
		$query = $this->db->get($this->name_table);
		return $query->result_array();
	}
	public function news($limit,$start_from)//Вивід всіх новин по сторінках
	{
		$this->db->select('news.news_id,news.title_news,news.small_img,news.short_text,news.text,news.views,news.data,users_info.surname,users_info.name');
		$this->db->from($this->name_table);
		$this->db->order_by('data','desc');
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		$this->db->limit($limit,$start_from);
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_grid($sidx,$sord,$start,$limit,$where)//Пошук  публікованих jqgrid
	{
		$this->db->from($this->name_table);
		$array = array('publish' => '1');
		$this->db->where($array); 
		if($where!='')$this->db->where($where,NULL,FALSE);
		$this->db->limit($limit,$start);
		$this->db->order_by($sidx,$sord); 
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->result_array();	
	}
	public function get_new_grid($sidx,$sord,$start,$limit,$where)//Пошук нових новин для jqgrid
	{
		$this->db->from($this->name_table);
		$array = array('publish'=>'0');
		//$this->db->limit($limit,$start_from);	
		$this->db->where($array);
		if($where!='')$this->db->where($where,NULL,FALSE);
		//$this->db->order_by($sidx,$sord); 
		$this->db->join('users_info', 'users_info.id_user = news.author','left');	
		$query = $this->db->get();
		return $query->result_array();
	}
	public function count_all()//Підрахунок всіх публікованих
	{
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		$this->db->from($this->name_table);
		return $this->db->count_all_results();
	}
	public function count_new()//Підрахунок всіх нових
	{
		$this->db->where('publish','0');
		$this->db->from($this->name_table);
		return $this->db->count_all_results();
	}
	public function count_where($id)//Підрахунок доданих користувачем
	{
		$array = array('author' => $id);
		$this->db->where($array); 
		$this->db->from($this->name_table);
		return $this->db->count_all_results();
	}
	public function count_grid($where)//Підрахунок публікованих для jqgrid
	{
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		if($where!='')$this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	public function count_new_grid($where)//Підрахунок непублікованих для jqgrid
	{
		$this->db->where('publish','0');
		if($where!='') $this->db->where($where);
		return $this->db->count_all_results($this->name_table);
	}
	
	public function feeds_info()//RSS
	{
		$array = array('publish' => '1', 'data <' => date('Y-m-d H:i:s'));
		$this->db->where($array); 
		$this->db->order_by('data','desc');
		$this->db->limit(20);
		$query = $this->db->get($this->name_table);
		return $query->result_array();
	}	
	public function delete_user($id,$id_user)//Видалення не публікованих новин користувачем
	{
		$array = array('author'=>$id_user,'publish'=>'0','news_id'=>$id);
		$this->db->where($array);
		return $this->db->delete($this->name_table);
	}
}