<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_lib
{
	public function do_login($email,$pass)//Авторизація
	{
		$CI =& get_instance();
		$CI->load->model('users_model');
		$data =  $CI->users_model->get_by($email);
		$ses = array();
		//Якщо порожній масив $res
		if (empty($data))
		{
			
			echo json_encode('Невірно введений email або пароль');
		}
		else
		{
			//Перевірка на співпадання паролю
			if ($pass == $data['pass']) 
			{ 
				$ses['id_user'] = $data['id_user'];
				$ses['logged_in'] = true;
				$CI->session->set_userdata($ses);
				echo 1;
				
			}
			else
			{  
				echo json_encode('Невірно введений email або пароль');
			}
		}	
	}
	public function do_logout()//Вихід
	{
		$CI =& get_instance();
		$ses = array();
		$ses['id_user'] = '';
		$ses['logged_in'] = '';
		$CI->session->unset_userdata($ses);
		redirect(base_url());
	}

	public function check_users_logIn()//Чи ввійшов користувач на сайт
	{
		$CI =& get_instance();
		if ($CI->session->userdata('logged_in') == 1)
		{
			return TRUE;
		}
	
		else
		{
			return false;
		}
	}
	public function userMenu()//Меню для користувачів
	{
		$html = '';
		$html.='<div class="menu" id="userMenu"><div class="name">Моє меню</div><div class="area">';
		$html.='<ul><li><a href="/users/page/my_page">Моя сторінка</a></li>';
		$html .= '<li>Мої новини:
		<a href="/users/page/add_news" title="Додати">
			<button type="button" class="add">Дод.</button>
		</a>
		<a href="/news/all_where" title="Переглянути">
			<button type="button" class="view">Пер.</button>
		</a></li>';
		$html .= '<li>Мої фотографії:
		<a href="/photo/add" title="Додати">
			<button type="button" class="add">Дод.</button>
		</a>
		<a href="/photo/" title="Переглянути">
			<button type="button" class="view">Пер.</button>
		</a></li>';
		//$html .= '<li><a href="/users/page/video">Мої відеозаписи:</a></li>';
		$html .= '<li><a href="/users/logout">Вийти</a></li>';
		$html.='</ul></div></div>';
		return $html;
	}
}