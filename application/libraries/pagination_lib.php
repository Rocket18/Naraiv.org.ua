<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagination_lib
{
	public function get_settings($total,$limit,$start,$page)
	{
		$CI = & get_instance();
		$lastpage = ceil($total/$limit);
		$config = array();
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['first_link'] = '1';
		$config['last_link'] = $lastpage;
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['base_url'] = base_url().'news/all'.$page;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<div id="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_tag_open'] = '<li class="first">';
		if($start > 3*$limit)
			$config['first_tag_close'] = '</li><li class="point">. . .</li>';
		else
			$config['first_tag_close'] = '</li>';
		if($start < ($lastpage-4)*$limit)
			$config['last_tag_open'] = '<li class="point">. . .</li><li class="last">';
		else
			$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="prev">Попередня';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="next">Наступна';
		$config['next_tag_close'] = '</li>';
		
		return $config;
		
	}	
	public function get_photo($total,$limit,$start,$category)
	{
		$CI = & get_instance();
		$lastpage = ceil($total/$limit);
		$config = array();
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['first_link'] = '1';
		$config['last_link'] = $lastpage;
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['base_url'] = base_url().'photo/get/'.$category;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<menu  id="pag_photo""><ul>';
		$config['full_tag_close'] = '</ul></menu>';
		$config['first_tag_open'] = '<li class="first">';
		if($start > 3*$limit)
			$config['first_tag_close'] = '</li><li class="point">. . .</li>';
		else
			$config['first_tag_close'] = '</li>';
	
		if($start < ($lastpage-4)*$limit)
			$config['last_tag_open'] = '<li class="point">. . .</li><li class="last">';
		else
			$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="prev">Попередня';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="next">Наступна';
		$config['next_tag_close'] = '</li>';
		return $config;
	}	
	public function get_video($total,$limit,$start)
	{
		$CI = & get_instance();
		$lastpage = ceil($total/$limit);
		$config = array();
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['first_link'] = '1';
		$config['last_link'] = $lastpage;
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['base_url'] = base_url().'video/get';
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<menu  id="pag_photo""><ul>';
		$config['full_tag_close'] = '</ul></menu>';
		$config['first_tag_open'] = '<li class="first">';
		if($start > 3*$limit)
			$config['first_tag_close'] = '</li><li class="point">. . .</li>';
		else
			$config['first_tag_close'] = '</li>';
	
		if($start < ($lastpage-4)*$limit)
			$config['last_tag_open'] = '<li class="point">. . .</li><li class="last">';
		else
			$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="prev">Попередня';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="next">Наступна';
		$config['next_tag_close'] = '</li>';
		return $config;
	}		
}