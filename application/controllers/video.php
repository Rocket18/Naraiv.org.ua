<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('video_model');
		$this->load->library('breadcrumb_lib');
		$this->load->library('menu_lib'); //загрузка бібліотеки
		$this->load->library('poll_lib');
		$this->load->library('auth_lib');

	}
	public function index()
	{
		redirect(base_url());
	}
	public function get($start_from = '')
	{
		$data = array();
		$this->Menu_lib = new Menu_lib(); 
		if($this->auth_lib->check_users_logIn())
		{
			$id_user = $this->session->userdata('id_user');
			$data['ses'] = "isLogin";
			$access = $data['ses'];
			$data['userMenu'] = $this->auth_lib->userMenu();
			
		}
		else
			$access = '';
	
		$this->load->library('pagination');
		$this->load->library('pagination_lib');
		$total = $this->video_model->v_count_all($access);
		$limit = 8;
		$settings = $this->pagination_lib->get_video($total,$limit,$start_from);
		$this->pagination->initialize($settings); 
		$data['poll'] = $this->poll_lib->get_poll();
		$data['video'] = $this->video_model->get($limit,$start_from,$access);
		$data['title'] = 'Відео';
		$data['description'] = 'Відеогаларея села Нараїв';
		$data['keywords'] = 'відеоальбом, кулеби';
		$data['last_news'] =  $this->news_model->last_news(); 
		$data['popular_news'] =  $this->news_model->popular_news(); 
		$data['css'][] = '<link rel="stylesheet" href="/css/video.css">';
		$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
		$data['page_nav'] = $this->pagination->create_links();
		$name = 'content/video';
		$this->display_lib->page($data,$name);	
	}
	public function add()
	{
		if($this->input->is_ajax_request())
		{
			
			foreach($_POST as $key => $val)
			{
				$data[$key] = $val;
			}
			unset($data['sub']);
			if($this->auth_lib->check_users_logIn())
					$data['author']= $this->session->userdata('id_user');
			else
			{
				$data['author'] = $this->input->ip_address();//Отримуємо IP-користувача	
				$data['access'] .= 3;
			}
			$data['cat'] = 4;
			$this->video_model->add($data);
		}
		else
		{
			$this->Menu_lib = new Menu_lib(); 
			if($this->auth_lib->check_users_logIn())
			{
				
					$id_user = $this->session->userdata('id_user');
					$data['ses'] = "isLogin";
					$data['userMenu'] = $this->auth_lib->userMenu();
			}
			$data['last_news'] = $this->news_model->last_news();
			$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
			$data['poll'] =  $this->poll_lib->get_poll();
			$data['title']='Додати відео';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['description'] = 'Додавайте відеозаписи на сайт с.Нараїв';
			$data['keywords'] = 'відео,upload';
			$data['css'][] = '<link rel="stylesheet" href="/css/video.css">';	
			$name = 'content/video_add';
			$this->display_lib->page($data,$name);
		}
	}
	
	//CALL THIS METHOD FIRST BY GOING TO
	//www.your_url.com/index.php/request_youtube
	/*public function request_youtube()
	{
		$params['key'] = $this->config->item('google_consumer_key');
		$params['secret'] = $this->config->item('google_consumer_secret');
		$params['algorithm'] = 'HMAC-SHA1';
		
		$this->load->library('google_oauth', $params);
		$data = $this->google_oauth->get_request_token(site_url('video/upload'));
		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']); 
	}
	//This method will be redirected to automatically
	//once the user approves access of your application
	public function access_youtube()
	{
		$params['key'] = $this->config->item('google_consumer_key');
		$params['secret'] = $this->config->item('google_consumer_secret');
		$params['algorithm'] = 'HMAC-SHA1';
		
		$this->load->library('google_oauth', $params);
		
		$oauth = $this->google_oauth->get_access_token(false, $this->session->userdata('token_secret'));
		
		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
	}
	
	//This method can be called without having
	//done the oauth steps
	public function youtube_no_auth()
	{
		$params['apikey'] = $this->config->item('youtube_api_key');
		
		$this->load->library('youtube', $params);
		echo $this->youtube->getKeywordVideoFeed('pac man');
	}
	
	//This method can be called after you executed
	//the oauth steps
	public function youtube_auth()
	{
		$params['apikey'] = $this->config->item('youtube_api_key');
		$params['oauth']['key'] = $this->config->item('google_consumer_key');
		$params['oauth']['secret'] = $this->config->item('google_consumer_secret');
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
												 'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		
		$this->load->library('youtube', $params);
		echo $this->youtube->getUserUploads();
	}
	
	public function direct_upload()
	{
		$videoPath = 'video';
		$videoType = 'video/3gpp,video/x-msvideo,video/mp4,video/quicktime'; //This is the mime type of the video ex: 'video/3gpp'
		
		$params['apikey'] = $this->config->item('youtube_api_key');
		$params['oauth']['key'] = $this->config->item('google_consumer_key');
		$params['oauth']['secret'] = $this->config->item('google_consumer_secret');
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
												 'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		$this->load->library('youtube', $params);
		
		$metadata = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:yt="http://gdata.youtube.com/schemas/2007"><media:group><media:title type="plain">Test Direct Upload</media:title><media:description type="plain">Test Direct Uploading.</media:description><media:category scheme="http://gdata.youtube.com/schemas/2007/categories.cat">People</media:category><media:keywords>test</media:keywords></media:group></entry>';
		echo $this->youtube->directUpload($videoPath, $videoType, $metadata);
	}
	public function upload()
	{
		$name = 'content/upload';
		$data = '';
		$this->display_lib->page($data,$name);	
	}*/
}