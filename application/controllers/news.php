<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumb_lib');
		$this->load->model('main_model');
		$this->load->library('menu_lib'); //загрузка бібліотеки
		$this->load->library('poll_lib'); 
		
	}
	public function index()
	{
		
		redirect(base_url());
		//Очищення папки на php
		/*$dir = './uploads';
		$del = false;
		if ($descriptor = opendir($dir))
		{
			$files = array_diff(scandir($dir), array('.', '..'));
			foreach ($files as $file)
			(is_dir($dir.'/'.$file)) ? clear_dir($dir.'/'.$file, true) : unlink($dir.'/'.$file);
			closedir($descriptor);
			if ($del){rmdir($dir);} 
					 }*/
	}
	public function limit()
	{
		if($this->input->is_ajax_request())
		{
			$limit = $this->input->post('limit');
			$this->input->set_cookie('limit',$limit,0);
		}
		else
			show_404();		
	}
	public function all($start_from = '')
	{
		$this->load->library('pagination');
		$this->load->library('pagination_lib');
		if($this->input->cookie('limit'))
			$limit = $this->input->cookie('limit');
		else
			$limit = 5;	
		$this->Menu_lib = new Menu_lib(); 
		if ($this->session->userdata('logged_in') === true)
		{
			$data['ses'] = "isLogin";
			$this->load->library('auth_lib');
			$data['userMenu'] = $this->auth_lib->userMenu();
		}
		$total = $this->news_model->count_all();
		$settings = $this->pagination_lib->get_settings($total,$limit,$start_from,$page='');
		$this->pagination->initialize($settings);
		$data['poll'] =  $this->poll_lib->get_poll();
		$data['limit'] = $limit;
		$temp  = $this->main_model->getInfNews();
		$data['news'] = $this->news_model->news($limit,$start_from);
		$data['page_nav'] = $this->pagination->create_links();
		$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
		$data['css'][] = '<link rel="stylesheet" href="/css/news.css" >'; 
		$data['title'] =  $temp['title'];
		$data['description'] = $temp['description'];
		$data['keywords'] = $temp['keywords'];
		$data['is_news'] = "is_news";

		$data['js'] = '
		$(function(){
			
			
		 applyPagination();
    function applyPagination() {
     $("#pagination a").click(function() {
		
        var url = $(this).attr("href");
        $.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() {
			$("body,html").animate({scrollTop: 0}, 1000);
			
            $("#content").html("Зачекайте");
          },
          success: function(msg) {
            $("#content").html(msg);
            applyPagination();
			
          }
        });
        return false;
      });
    }
	});
		';	

		$name = 'content/news_all';
		if ($this->input->post('ajax')) {
      	$this->load->view($name.'2_view', $data);
	    } 
		else 
		{
			$this->display_lib->page($data,$name);
		}
	}
	public function all_where($start_from = '')
	{
		$this->load->library('auth_lib');
		if($this->auth_lib->check_users_logIn())
		{
			$this->load->library('pagination');
			$this->load->library('pagination_lib');
			if($this->input->cookie('limit'))
				$limit = $this->input->cookie('limit');
			else
				$limit = 5;	
			$page = '_where';
			$this->Menu_lib = new Menu_lib(); 
			$id = $this->session->userdata('id_user');
			$data['ses'] = "isLogin";
			$data['userMenu'] = $this->auth_lib->userMenu();
			$total = $this->news_model->count_where($id);
			$settings = $this->pagination_lib->get_settings($total,$limit,$start_from,$page);
			$this->pagination->initialize($settings);
			$data['poll'] =  $this->poll_lib->get_poll();
			$data['limit'] = $limit;
			$temp  = $this->main_model->getInfNews();
			$data['news'] = $this->news_model->news_user($limit,$start_from,$id);
			$data['page_nav'] = $this->pagination->create_links();
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
			$data['css'][] = '<link rel="stylesheet" href="/css/news.css" >'; 
			$data['title'] =  $temp['title'];
			$data['description'] = $temp['description'];
			$data['keywords'] = $temp['keywords'];
			$data['is_news'] = "is_news";
			$data['js'] = '
			$(function(){
			 applyPagination();
		function applyPagination() {
		 $("#pagination a").click(function() {
			var url = $(this).attr("href");
			$.ajax({
			  type: "POST",
			  data: "ajax=1",
			  url: url,
			  beforeSend: function() {
				$("body,html").animate({scrollTop: 0}, 1000);
				$("#content").html("Зачекайте");
			  },
			  success: function(msg) {
				$("#content").html(msg);
				applyPagination();
			  }
			});
			return false;
		  });
		}
		});
			';	
			$name = 'content/news_all_where';
			if ($this->input->post('ajax')) 
				$this->load->view('content/'.$name.'_view', $data);
			else 
				$this->display_lib->page($data,$name);
			
		}
		else
			show_404();
	}
	public function show($news_id)
	{
		if ($this->session->userdata('logged_in') === true)
		{
			$data['ses'] = "isLogin";
			$data['userMenu'] = $this->auth_lib->userMenu();
		}
		$data['news_all'] = $this->news_model->get($news_id);
		
		if(empty($data['news_all']))
			show_404();
		else
		{
			
			$data['poll'] =  $this->poll_lib->get_poll();
			$this->Menu_lib = new Menu_lib(); 
			$ip = $this->input->ip_address();//Отримуємо IP-користувача
		
			$mass = $data['news_all'];//$this->news_model->get($news_id);
			$cookie['name'] =   'views';
			$cookie['expire'] =   time() + 1*30*24*60*60;//1 місяць
			$ID = array();
			$address = array();
			if($mass['views'] == 0)
			{
				$address[] = $ip; //Додаємо нову IP-адресу в масив з IP-адресами
			
				//Додаємо id новини в cookie
				$ID[] =  $news_id; 
				$cookie['value'] = serialize($ID);
				$this->input->set_cookie($cookie);
				
				$row['ip'] = serialize($address);//Cіріалізуємо масив
				$row['views']  = 1; //Кількість переглядів стає 1
				$this->news_model->update($row,$news_id);//Оновлення переглядів
			}
			else
			{
				$address = unserialize($mass['ip']);//Масив з Ip-адресами
				if (in_array($ip, $address))//Якщо в масиві вже є такий IP-адрес
				{
					
				}
				else if($this->input->cookie('views'))//Чи є кукі
				{
					
						$ID = unserialize($this->input->cookie('views'));
						if(in_array($news_id, $ID))//Якщо ID новини є в кукі
						{
							//Оновлення часу кукі
							$cookie['value'] = $this->input->cookie('views');
							$this->input->set_cookie($cookie);
						}
						else
						{
							//Запис cookie та IP і оновлення перегляду
							$ID[] = $news_id;
							$cookie['value'] = serialize($ID);	
							$this->input->set_cookie($cookie);
							$address[] = $ip;
							$row['ip'] = serialize($address);
							$row['views']  = count($address);//Підрахунок кількості переглядів
							$this->news_model->update($row,$news_id);//Оновлення переглядів
						}
				}
				else//Якщо нема кукі
				{
					//Запис cookie та IP і оновлення перегляду
					$ID[] = $news_id;
					$cookie['value'] = serialize($ID);	
					$this->input->set_cookie($cookie);
					$address[] = $ip;
					$row['ip'] = serialize($address);
					$row['views']  = count($address);//Підрахунок кількості переглядів
					$this->news_model->update($row,$news_id);//Оновлення переглядів
				}
			}
			$data['last_news'] = $this->news_model->last_news();
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['script'][] = '<script  src="http://userapi.com/js/api/openapi.js?50"></script>';
			$data['title'] = $data['news_all']['title_news'];
			$data['description'] = $data['news_all']['short_text'];
			$data['keywords'] =  $data['news_all']['keywords'];
			$data['css'][] =  '<link rel="stylesheet" href="/css/news.css" >';
			$name = 'content/news';
			$this->display_lib->page($data,$name);
		}
	}
	public function show_where($news_id)
	{
		$this->load->library('auth_lib');
		if($this->auth_lib->check_users_logIn())
		{
			
				$id_user = $this->session->userdata('id_user');
				$data['ses'] = "isLogin";
			
			$data['news_all'] =  $this->news_model->news_where_user($news_id,$id_user);
			if(empty($data['news_all']))
				show_404();
			else
			{
				$data['userMenu'] = $this->auth_lib->userMenu();
				$data['poll'] =  $this->poll_lib->get_poll();
				$this->Menu_lib = new Menu_lib(); 
				$data['last_news'] = $this->news_model->last_news();
				$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
				$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
				$data['script'][] = '<script  src="http://userapi.com/js/api/openapi.js?50"></script>';
				$data['title'] = $data['news_all']['title_news'];
				$data['description'] = $data['news_all']['short_text'];
				$data['keywords'] =  $data['news_all']['keywords'];
				$data['css'][] =  '<link rel="stylesheet" href="/css/news.css" >';
				$data['script'][]  = '<script src="/js/comments_add.js"></script>';
				$name = 'content/news';
				$this->display_lib->page($data,$name);
			}
		}
	}
	private function add_news()
	{
		$this->auth_lib->check_users_logIn();
		$data['id'] = $this->session->userdata('id_user');
		
		$this->load->library('ckeditor'); //загрузка бібліотеки
		$this->CI_CKEditor = new CI_CKEditor('/ckeditor/'); //шлях до папки редактора
		$this->CI_CKEditor->textareaAttributes = array( "rows" => 25, "cols" => 20,"id"=>"ckeditor" ); //актрибути текстового поля
		$data = array();
		$data['script'][] = '<script src="/js/site.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/ajaxfileupload.js"></script>';
		$data['title']='Додати новину';
		$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
		$data['description'] = 'Додайте нові новина на сайт с.Нараїв';
		$data['keywords'] = 'новини Нараєва,додати';
		$name='content/add_news';
		
		$this->display_lib->page($data,$name);	
		
	}
	public function add($id="")
	{
		if($this->input->is_ajax_request())
	   {
			foreach($_POST as $Key => $Val)
			{
				$data[$Key] = $Val;
			}	
				unset ($data['sub']);
				unset ($data['userfile']);
				
				if(empty($id))
				{
					$data['ip'] = '';
					$this->news_model->add($data);
					echo json_encode("Новину успішно додано");
				}
				else
				{
					$this->news_model->update($data,$id);
					echo json_encode("Новину успішно оновлено");
				
				}
	   }
		else
			show_404();
	}
	public function delete($id)
	{
		$this->load->library("auth_lib");
		if($this->auth_lib->check_users_logIn())
		{
			$id_user = $this->session->userdata('id_user');
			if($this->news_model->delete_user($id,$id_user))
				redirect('/news/all_where');
		}
	}
	public function rss()
	{
		$data = array('feeds' => $this->news_model->feeds_info());
		$this->load->view('all/rss_view',$data);
	}
	
	
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */