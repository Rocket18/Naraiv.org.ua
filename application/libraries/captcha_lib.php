<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_lib
{
	public function captcha_actions()
	{
		$CI =& get_instance();	
		$CI->load->helper('captcha');
		$CI->load->helper('string');
		$code  = random_string('numeric',4);
		$ses_data = array();
		$ses_data['code'] = $code;
		$CI->session->set_userdata($ses_data);
		$setting = array
		(
			'word'	     => $code,
			'img_path'   => 'img/captcha/',
			'img_url'    => base_url().'img/captcha/',
			/*'font_path'  => 'system/fonts/bobcat.ttf',*/
			'img_width'  => 100,
			'img_height' => 30,
			'expiration' => 10
		);
		$captcha = create_captcha($setting);
		$imgcode = $captcha['image'];
		return $imgcode;
	}	
}