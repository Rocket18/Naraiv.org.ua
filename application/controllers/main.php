<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('main_model');
		$this->load->library('breadcrumb_lib');
		$this->load->library('poll_lib');
		
	}
	public function index()
	{
		//show_404();
		$this->load->config('SocialAuther');
		$er = $this->config->item('adapterConfigs','SocialAuther');
		var_dump($er);
		//$this->load->library('Ulogin');
		//$this->load->library('Uauth');
		//$data = new Ulogin;
		//$w = new Uauth;
		//print_r($w->logout());
		
	
	//print_r($data->get_html());
	//print_r($data->userdata());
	}
	public function show($pages_id)
	{
		if ($this->session->userdata('logged_in') === true)
		{
			$data['ses'] = "isLogin";
			$this->load->library('auth_lib');
			$data['userMenu'] = $this->auth_lib->userMenu();
		}
		$data['poll'] =  $this->poll_lib->get_poll();
		$data['mass'] = $this->main_model->get($pages_id);
		$data['title'] = $data['mass']['title'];
		$data['description'] = $data['mass']['description'];
		$data['keywords'] = $data['mass']['keywords'];
		$this->load->library('menu_lib'); //загрузка бібліотеки
		$this->Menu_lib = new Menu_lib(); //Створення класу меню
		switch($pages_id)
		{
			case 'history':
			$name = 'content';
			$data['script'][] = '<script  src="/js/imtech_pager.js"></script>';
			$data['js'] = "
							pager.paragraphsPerPage = 8; // Устанавливаем количество элементов на странице
							pager.pagingContainer = $('#text'); // Устанавливаем основной контейнер
							pager.paragraphs = $('p', pager.pagingContainer); // Подсчитываемые элементы
							pager.showPage(1); // Начинаем просмотр с первой страницы
							";
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$this->display_lib->page($data,$name);
			
			break;
			case 'school1':
			$name = 'content';
			$data['script'][] = '<script src="/js/imtech_pager.js"></script>';
			$data['js'] = "
							pager.paragraphsPerPage = 8; // Устанавливаем количество элементов на странице
							pager.pagingContainer = $('#text'); // Устанавливаем основной контейнер
							pager.paragraphs = $('p', pager.pagingContainer); // Подсчитываемые элементы
							pager.showPage(1); // Начинаем просмотр с первой страницы
							";
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини	  
			$this->display_lib->page($data,$name);
		
			break;
			case 'school2':
			$name = 'content';
			$data['script'][] = '<script src="/js/imtech_pager.js"></script>';
			$data['js'] = "
							pager.paragraphsPerPage = 8; // Устанавливаем количество элементов на странице
							pager.pagingContainer = $('#text'); // Устанавливаем основной контейнер
							pager.paragraphs = $('p', pager.pagingContainer); // Подсчитываемые элементы
							pager.showPage(1); // Начинаем просмотр с первой страницы
							";
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини	  
			$this->display_lib->page($data,$name);
		
			break;
			
			
			case 'maps':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$this->display_lib->page($data,$name);
			break;
			
			case 'national':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$data['script'][] = '<script src="/js/imtech_pager.js"></script>';
			$data['js'] = "
							pager.paragraphsPerPage = 8; // Устанавливаем количество элементов на странице
							pager.pagingContainer = $('#text'); // Устанавливаем основной контейнер
							pager.paragraphs = $('p', pager.pagingContainer); // Подсчитываемые элементы
							pager.showPage(1); // Начинаем просмотр с первой страницы
							";
			$this->display_lib->page($data,$name);
			break;
			
			case 'change':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини	
			$this->display_lib->page($data,$name);
			break;
			
			case 'feedback':
			$this->load->library('captcha_lib');
			$name = 'content/feedback';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини 
			$data['imgcode'] = $this->captcha_lib->captcha_actions();
			$this->display_lib->page($data,$name);
			break;
			
			case 'contact':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			
			$this->display_lib->page($data,$name);
			break;
			case 'film':
			$name = 'content/film';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$this->display_lib->page($data,$name);
			break;
			case 'advert':
			$name = 'content/advert';
			$this->load->model('users_model');
			$data['advert'] = $this->users_model->advert();
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини

			
			$this->display_lib->page($data,$name);
			break;
			case 'lessons':
			$name = 'content/lessons';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$data['css'][] = '<link rel="stylesheet" type="text/css" media="screen" href="/css/ui.jqgrid.css" mce_href="css/ui.jqgrid.css" />';
			$data['script'][] = '<script src="/js/jquery.jqgrid.min.js"></script>';
			$data['script'][] = '<script type="text/javascript" src="/js/jqgrid/grid.locale-ua.js"></script>';
			$data['script'][] = '<script type="text/javascript" src="/js/jqgrid/grid.grouping.js"></script>';
			$data['script'][] = '<script src="/js/lessons.js"></script>';
			
			
			$this->display_lib->page($data,$name);
			break;
			
			case 'about_as':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['last_news'] =  $this->news_model->last_news();//Останні новини 
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$this->display_lib->page($data,$name);
			break;
			
			case 'index':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			//Останні новини
			$data['last_news'] =  $this->news_model->last_news(); 	
			//Популярні новини
			$data['popular_news'] = $this->news_model->popular_news();
			$this->display_lib->page($data,$name);
			break;
			
			case 'buses':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			//Останні новини
			$data['last_news'] =  $this->news_model->last_news(); 	
			//Популярні новини
			$data['popular_news'] = $this->news_model->popular_news();
			$this->display_lib->page($data,$name);
			break;
			
			case 'Kulebu':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			//Останні новини
			$data['last_news'] =  $this->news_model->last_news(); 	
			//Популярні новини
			$data['popular_news'] = $this->news_model->popular_news();
			$this->display_lib->page($data,$name);
			break;
			case 'guta':
			$name = 'content';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			//Останні новини
			$data['last_news'] =  $this->news_model->last_news(); 	
			//Популярні новини
			$data['popular_news'] = $this->news_model->popular_news();
			$this->display_lib->page($data,$name);
			break;
			default : show_404();
			
		}
	}
	public function prognoz()
	{
		if($this->input->is_ajax_request())
		{
			$file = FCPATH.'/file/ip.txt';//шлях до файлу
			$data = mktime(0,0,0,date('m'),date('d'),date('Y'));//дата в форматі UNIX
			$ip = $this->input->ip_address();//IP адреса
			if(file_exists($file))//Чи є файл
			{
				$mass = array();
				$mass = file($file);
				if($mass[0] < $data)//Чи новий день
				{
					/*Очистка файлу і запис нової дати*/
					$f = fopen($file,"w");
					flock($f,LOCK_EX);
					fwrite($f,$data."\n");
					fwrite($f,$ip."\n");
					flock($f,LOCK_UN);
					fclose($f);
					$this->get_prognoz();
				}
				else
				{
					
					$f = fopen($file,"a");	
					if(!(in_array($ip."\n",$mass)))//Якшо IP нема
					{
						flock($f,LOCK_EX);
						fwrite($f,$ip."\n");
						flock($f,LOCK_UN);
						fclose($f);
						$this->get_prognoz();
					}
				}
			}
			else//Створення файлу, запис поточної дати та IP
			{
				$f = fopen($file,"a");
				flock($f,LOCK_EX);
				fwrite($f,$data."\n");
				fwrite($f,$ip."\n");
				flock($f,LOCK_UN);	 
				fclose($f);
				$this->get_prognoz();
			}
		}
		else
			show_404();		
	

			
	}
	private function get_prognoz()
	{
		$count =  $this->main_model->countTable('prevision');
		$id = rand(1, $count);
		$msg =  $this->main_model->prognoz($id);
		echo $msg['prognoz'];	
		
	}
	public function get_lessons($school)//Отримання розкладу уроків і запис в jqgrid
	{
		if($this->input->is_ajax_request())
		{
			$row =  $this->main_model->lessons($school);
			$n=0;
			$les=array();
			$day = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			foreach($row as $Key=>$val)
			{
				$i=0;
				for($i=0;$i<6;$i++)
				{
					$les[$day[$i]]  = unserialize($row[$Key][$day[$i]]);
				}
				$j=0;$i=0;
				for($j=0;$j<8;$j++)
				{
					$data->rows[$n]['id'] = $row[$Key]['class'];
					$data->rows[$n]['cell'] = array( ++$i,$row[$Key]['class'],$les['Monday'][$j],$les['Tuesday'][$j],$les['Wednesday'][$j],$les['Thursday'][$j],$les['Friday'][$j],$les['Saturday'][$j]);
					$n++;
				}
			}
			header("Content-type: text/script;charset=utf-8");
			echo json_encode($data);	
		}
		else
			show_404();
	} 
	private function addFilm()
	{
		$data = array();
		$data['name'] = $this->input->post('name');
		$data['year'] = $this->input->post('year');
		$data['ip'] = $_SERVER["REMOTE_ADDR"];
		
		foreach($this->input->post('cat') as $val)
		{
			$data['cat'.$val] = 1;
    		
		}	
		$this->main_model->insertMain('movies',$data);
		echo json_encode("Велике спасибі за ваш вклад у наш сайт");
	}
	private function getFilm()
	{
		$year = $this->input->post('year');
		foreach($this->input->post('cat') as $val)
		{
			$data['cat'.$val] = 1;
    		
		}
		 $data = $this->main_model->getFilm($year,$data);
		 echo json_encode($data);
		 
	}
	public function feedback()
	{
		if($this->input->is_ajax_request())
		{
			$data['name'] = $this->input->post('name'); 
			$data['email'] = $this->input->post('email'); 
			$data['subject'] = $this->input->post('subject');
			$data['message'] = $this->input->post('message');
			$this->load->library('email');
			$this->email->from($data['email'], $data['name']);
			$this->email->to('support@naraiv.org.ua');
			$this->email->subject($data['subject']);
			$this->email->message($data['message']);
			$this->email->send();
			$msg = "Ваш лист успішно відправлено і буде розглянуто в найкоротший термін. ";
			echo json_encode($msg);
		}
		else
			show_404();
	
	}
	public function check_captcha()
	{
		if($this->input->is_ajax_request())
		{
			$captcha  = $this->input->post('captcha');
			$data = ($captcha == $this->session->userdata('code')) ? 'true': 'false';
			echo $data;
		}
		else
			show_404();
	}
	public function refresh_captcha()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->library('captcha_lib');
			$imgcode = $this->captcha_lib->captcha_actions();	
			echo $imgcode;
		}
		else
			show_404();
	}
	public function advertAdd()
	{
		if($this->input->is_ajax_request())
		{
			foreach($_POST as $key => $val)
			{
				$data[$key] = $val;
			}
			unset($data['sub']);
			$data['date'] = date("Y-m-d H:i:s");
			if($this->auth_lib->check_users_logIn())
				$data['ip_id'] = $this->session->userdata('id_user');
			else
				$data['ip_id']  = $this->input->ip_address();
			$this->main_model->insertMain('advertising',$data);
			
			
			
		}
		else
			show_404();
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
