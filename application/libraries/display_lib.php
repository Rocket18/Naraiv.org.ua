<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Display_lib
{
	private $CI;
	public function __construct()
	{
        $this->CI = &get_instance();
		

    }
	public function page($data,$name)
	{
		$this->CI->parser->parse('preheader_view',$data);
		$this->CI->load->view('header_view');
		$this->CI->load->view('menu_view');
		$this->CI->load->view($name.'_view',$data);
		$this->CI->load->view('aside_view',$data);
		$this->CI->load->view('footer_view');
	}
	public function admin_page($data,$name)
	{
		$this->CI->load->view('adminka/preheader_view');
		$this->CI->load->view('adminka/header_view');
		$this->CI->load->view('adminka/'.$name.'_view',$data);
		$this->CI->load->view('adminka/footer_view');
	}
	public function msg($data)
	{
		
		$this->CI->load->view('content/msg_view',$data);
	}


		
}