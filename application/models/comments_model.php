<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends Crud
{
	public $name_table = 'comments';
	public $id_page = 'comments_id';
	
	public function get_by($news_id)
	{
		$this->db->order_by('comments_id','desc');
		$this->db->where('matterials_id',$news_id);
		$this->db->limit(5);	
		$query = $this->db->get('comments');
		return $query->result_array();
	}
	public function add_comment($data)
	{
		$this->db->insert('comments',$data);
	}
			
}