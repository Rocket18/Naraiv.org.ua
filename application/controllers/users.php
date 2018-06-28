<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumb_lib');
		$this->load->model('users_model');
		$this->load->library('menu_lib'); //загрузка бібліотеки
		$this->load->library('poll_lib');
		$this->load->config('oauth2');

	}
	public function index()
	{
		show_404();
	}
	public function page($page,$id='')
	{
		$this->load->library('auth_lib');
		if($this->auth_lib->check_users_logIn())
		{
			$data['userMenu'] = $this->auth_lib->userMenu();
			$this->Menu_lib = new Menu_lib(); //Створення класу меню
			$data['poll'] = $this->poll_lib->get_poll();
			$data['ses'] = "isLogin";
			$data['css'][] = '<link href="/css/users.css" rel="stylesheet">';
			
			$id_user = $this->session->userdata('id_user');
			$data['id_user'] = $id_user;
			
			switch($page.'/'.$id)
			{
				case 'my_page/':
				
				$data['last_news'] =  $this->news_model->last_news();//Останні новини 
				$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
				$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
				$data['title'] = "Моя сторінка";
				$data['description'] = "Персональна сторінка користувача";
				$data['keywords'] = '';
				$data['news'] = $this->news_model->count_where($id_user);
				$this->load->model('photo_model');
				$data['photo'] = $this->photo_model->count_where($id_user);
				$data['user'] = $this->users_model->get_user($id_user);
				$name =  '/content/'.$page;
				$this->display_lib->page($data,$name);	
				break;	
				
				case 'add_news/'.$id:
				$this->load->library('ckeditor'); //загрузка бібліотеки
				$this->CI_CKEditor = new CI_CKEditor('/ckeditor/'); //шлях до папки редактора
				$this->CI_CKEditor->textareaAttributes = array( "rows" => 25, "cols" => 20,"id"=>"ckeditor" ); 
				$name='add_news';
				$data['id'] = $id;
				$data['script'][] = '<script  src="/js/File Upload/ajaxfileupload.js"></script>';
				$data['description'] = "Персональна сторінка користувача";
				$data['keywords'] = '';
				$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();
				$name =  '/content/'.$page;
				if(empty($id))
				{
					$data['title'] = "Додати новину";
					$this->display_lib->page($data,$name);
				}
				else
				{
					$data['news'] = $this->news_model->news_where_user($id,$id_user);
					$data['title'] = "Редагувати новину";
					if(empty($data['news']))
						//404
						redirect(base_url());
					else
						$this->display_lib->page($data,$name);	
					
				}
				
				 break;	
				 
		
			}
		}
		else
			show_404();	
	}
	
	public function oauth($provider = '')
	{
		$allowed_providers = $this->config->item('oauth2');
		if ( ! $provider OR ! isset($allowed_providers[$provider]))
        	show_404();
		$this->load->library('oauth2');
		$provider = $this->oauth2->provider($provider, $allowed_providers[$provider]);
        $args = $this->input->get();
        if ($args && !isset($args['code']))
          show_404();
        $code = $this->input->get('code', TRUE);
		if ( ! $code)
			$provider->authorize();
		else
		{
			$this->load->model('oauth_model');
			$token = $provider->access($code);
			$user = $provider->get_user_info($token);
			
			
			$uid = $user['uid'];
			$data = $this->oauth_model->get($uid);
			foreach($user as $key=>$val)
				$row[$key] = $val;	
			unset($row['urls']);
			$providers = array("Facebook","Vk");
			$key = array_search($providers,$user['urls']);//Пошук ключа
			$row['provider'] = $providers[$key];
			$row['url'] = $user['urls'][$providers[$key]];
			if(!isset($data))
				$this->oauth_model->add($row);
			else
				if($row != $data)
					$this->oauth_model->update($row,$uid);	
	
			$ses = array();
			$ses['id_user'] = $uid;
			$ses['logged_in'] = true;
			$this->session->set_userdata($ses);
		}
        redirect();
	}
	
	public function edit()
	{
		if($this->input->is_ajax_request())
		{
			if($this->auth_lib->check_users_logIn())
			{
				$id = $this->session->userdata('id_user');
				foreach($_POST as $Key => $Val)
				{
					 $data[$Key] = $Val;
				}
				$this->users_model->update_info($data,$id);
			}
		}
		else
			show_404();
		
	}
	public function changeEmail()
	{
		if($this->input->is_ajax_request())
		{
			$id = $this->session->userdata('id_user');
			$data = $this->users_model->get_email($id);	
			$confirm_link = base_url()."users/email_recover/".$data['confirm_code'];
			$to = $data['email'];
			$subject = 'Зміна email на сайті '.base_url();
			$message = "Для зміни email перейдіть по силці нижче\n ".$confirm_link;
			$this->sendEmail($subject,$to,$message);
		}
		else
			show_404();
	}
	public function changePass()
	{
		if($this->input->is_ajax_request())
		{
			if($this->auth_lib->check_users_logIn())
			{
				$id = $this->session->userdata('id_user');
				$pass = $this->input->post('pass');
				$pass2 = $this->users_model->get_pass($id);	
				if($pass2['pass']===md5($pass))
					echo '1';
				else
					echo '0';
			}
		}
		else
			show_404();
	}
	public function updatePass()
	{
		if($this->input->is_ajax_request())
		{
			if($this->auth_lib->check_users_logIn())
			{
				$data['pass'] = md5($this->input->post('pass'));
				$id = $this->session->userdata('id_user');
				$this->users_model->update($data,$id);
			}
		}
		else
			show_404();
	}
	public function insert($table)
	{
		if($this->input->is_ajax_request())
		{
			
		
			foreach($_POST as $key => $value)
			{
				$data[$key] = $value;
			}
			unset($data['sub']);
			unset($data['rules']);
			$id = $this->session->userdata('id_user');
			if($id!=NULL)
			
				$data['ip_id'] = $id;
			
			else
			
				$data['ip_id'] = $this->input->ip_address();
				
			
			$data['date']=date('Y-m-d H:i:s');
			
			$this->users_model->insert($table,$data);
			
		}
		else
			show_404();
		
	}
	
	//Реєстрація
	public function check_email()
	{
		if($this->input->is_ajax_request())
		{
			$email = ucfirst(strtolower(trim($this->input->post('email'))));
			$data = $this->users_model->get_by($email);	
			if(empty($data))
			{
				echo 1;
			}
			else
			{
				echo 0;	
			}
		}
		else
			show_404();
	}

	public function add()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->helper('string');
			$data = array();
			$data['email'] = ucfirst(strtolower(trim($this->input->post('email'))));
			$data['pass'] = '';
			$data['datatime'] = '';
			$data['confirm_code'] = random_string('alnum',20);
			$confirm_link = base_url()."users/reg_confirm/".$data['confirm_code'];
			$this->users_model->add_user($data);
			$to = $data['email'];
			$subject = 'Підтвердження реєстрації на сайті '.base_url();
			$message = "Для підтвердження реєстрації перейдіть по силці нижче або скопіюйте її в адресну строку\n ".$confirm_link;
			$this->sendEmail($subject,$to,$message);
			$msg = 'Для закінчення реєстрації відвідайте вашу пошту -  '.$data['email'].' і перейдіть по спеціальній силці';
			echo json_encode($msg);
		}
		else
			show_404();
		
	}
	
	public function reg_confirm()
	{
		$this->load->helper('string');
		$confirm_code = $this->uri->segment(3);
		$data = $this->users_model->check_confirm_code($confirm_code);
		if(empty($data) || empty($confirm_code))
			$msg['msg'] = 1;//Помилка підтвердження реєстрації	
		else
		{
			//Якщо анкаут ще не активовано
			if($data['stutus'] == 'waiting')
			{
				$data['stutus'] = 'active';
				$data['datatime'] = date('Y-m-d H:i:s');
				$pass = random_string('alnum',14);
				$data['confirm_code'] = random_string('alnum',20);
				$data['pass'] = md5($pass);
				$inf = array("id_user" => $data['id_user'],"surname" => '',"name" => '',"birth"=>'');
				$this->users_model->update_stutus($confirm_code,$data);
				$this->users_model->add_inf($inf);
				$msg['msg'] = 2;//Реєстрацію завершено
				//Відправка логіну і пароля користувачу
				$to = $data['email'];
				$subject = 'Підтверджкння реєстрації на сайті '.base_url();
				$message = "Вітаємо. Ви успішно пройшли реєстрацію.\nВаш email ".$data['email']." Ваш пароль - ".$pass."";
				$this->sendEmail($subject,$to,$message);
			
			}	
		}
			$this->display_lib->msg($msg);
	}
	public function update_inf()
	{
		if($this->input->is_ajax_request())
		{
			$id =  $this->session->userdata('id_user');
			foreach($_POST as $key => $val)
			{
				$data[$key] = $val;
			}
			$this->users_model->update_info($data,$id);
					
		}
		else
			show_404();
	
	}
	//Авторизація
	public function login()
	{
		if($this->input->is_ajax_request())
			$this->auth_lib->do_login($this->input->post('email'),md5(trim($this->input->post('pass'))));
		else
			show_404();
		
	}
	public function logout()
	{
		$this->auth_lib->do_logout();
	}
	
	public function recover()
	{
		if($this->input->is_ajax_request())
	   {
		  
		   $user_email = $this->input->post('email'); 
		   $res = $this->users_model->get_by($user_email); 
            if (empty($res))
                echo json_encode("Не існує користувача з таким email адресом");
			else if($res['stutus']=='active')
			{
				$confirm_link = base_url()."users/pass_recover/".$res['confirm_code'];
				$to = $this->input->post('email');
				$subject = 'Відновлення паролю'.base_url();
				$message = 'Для зміни паролю  перейдіть по силці нижче або скопіюйте її в адресну строку\n '.$confirm_link;
				$this->sendEmail($subject,$to,$message);
				echo 1;
	   		}
			else
			{
				 echo json_encode('Ваш анкаут ще не активовано');	
			}
	   }
	  else
			show_404();	   
    }
	public function pass_recover()
	{
		
		$confirm_code = $this->uri->segment(3);
		$data = $this->users_model->check_confirm_code($confirm_code);
		if(empty($data) || empty($confirm_code))
		{
			$msg['msg'] = 1;
		}
		else
		{
			$this->load->helper('string');
			$new_pass = random_string('alnum',14);           
			$data['pass'] = md5($new_pass);
			$data['confirm_code'] = random_string('alnum',20);
			$id = $data['id_user'];
			$this->users_model->recover($id,$data);
			$msg['msg'] = 4;
			$to = $data['email'];
			$subject = 'Новий пароль  на '.base_url();
			$message = 'Ваш новий пароль - '.$new_pass;
			$this->sendEmail($subject,$to,$message);
		}	
		$this->display_lib->msg($msg);
	}
	private function sendEmail($subject,$to,$message)
	{
		$this->load->library('email');                
		$this->email->from('support@Naraiv.org.ua',"Naraiv");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}
}
/* End of file users.php */
/* Location: ./application/controllers/users.php */