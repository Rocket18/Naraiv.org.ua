<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb_model extends Crud
{
	public function title_news($breadcrumb)
	{
		 $this->db->where('news_id',$breadcrumb);            
         $this->db->select('title_news');
         $query = $this->db->get('news'); 
		 return $query->row_array(); 
	}	
	 
}