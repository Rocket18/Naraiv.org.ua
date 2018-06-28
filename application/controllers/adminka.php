<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminka extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('main_model');
		$this->load->model('photo_model');
		$this->load->model('users_model');
		$this->load->model('video_model');
		$this->load->library('poll_lib');
	}

	public function index()
	{
		$this->load->view('adminka/root_view');
	}
	
	public function login()//Авторизація адміна
	{
		if($this->input->is_ajax_request())
		{
			$login = $this->input->post('email');
			$pass = md5(trim($this->input->post('pass')));
			if($this->config->item('login') === $login && $this->config->item('password') === $pass)
			{
				$ses = array();
				$ses['username'] = $login;
				$ses['logged_in'] = 'yes';
				$ses['admin_hash'] = $this->the_hash();
				$this->session->set_userdata($ses);
				echo true;
			}
			else
			{
				//3 спроби інакше блокування по ip + cooki
				$info='Невірно введений email або пароль';
				
				echo json_encode($info);
			}
		}
		else
			show_404();
	}
	
	public function logout()//Вихід адміна
	{
		$this->check_admin();
		$ses = array();
		$ses['username'] = '';
		$ses['logged_in'] = '';
		$ses['admin_hash'] = '';
		$this->session->unset_userdata($ses);
		redirect('/adminka/index');
	}
	private function the_hash()//Додатковий запис
	{
		$hash = md5($this->config->item('login').$_SERVER['REMOTE_ADDR'].'krasnytsia');
		return $hash;
	}
	public function check_admin()//Перевірка чи користувач є адміном
	{
		
		if ($this->session->userdata('username')===$this->config->item('login') && $this->session->userdata('logged_in')=== 'yes' /*&& $this->session->userdata('admin_hash')===$this->the_hash()*/)
		{
			return TRUE;
		}
		else
		{
			redirect(base_url().'adminka');
		}
	}
	

	
	public function show($page,$id="")//Вивід сторінок
	{
		$this->check_admin();
		$pages = array('photo','service','lessons','prevision','movies','users','video','school','advertising');
		switch($page.'/'.$id)
		{
			case 'root/':
			
		
		$data['service'] = $this->main_model->countTable('service');
		$data['photo'] = $this->photo_model->all_count();
		$data['video'] = $this->video_model->count_all() ;
		$data['users'] = $this->users_model->count_all();
		$name = 'content';
		$this->display_lib->admin_page($data,$name);
			break;
		case 'other/':
		$data['movies'] = $this->main_model->countTable('movies');
		$data['prevision'] = $this->main_model->countTable('prevision');
		if ($this->input->post('ajax')) 
      			$this->load->view('adminka/content/'.$page.'_view',$data);
			break;
					case 'poll/':
		$data['title'] = 'Додати опитування';
		$data['js'] = '<script src="/js/jQuery.WMAdaptiveInputs.js"></script>';
		$data['min_options'] = 2;
		$data['max_options'] = 6;

		if ($this->input->post('ajax')) 
      			$this->load->view('adminka/content/'.$page.'_view',$data);
			break;
			
			
			case 'news/':
			
		$name='content/news';
		$data['count_new'] = $this->news_model->count_new();
		$data['count_all'] = $this->news_model->count_all();
		if ($this->input->post('ajax')) {
      			$this->load->view('adminka/content/news_view',$data);
	    }else{$this->display_lib->admin_page($data,$name);}	
			break;
			
			
			
			case 'news_add/'.$id:
			
		$this->load->library('ckeditor'); //загрузка бібліотеки
		$this->CI_CKEditor = new CI_CKEditor('/ckeditor/'); //шлях до папки редактора
		$this->CI_CKEditor->textareaAttributes = array( "rows" => 25, "cols" => 20,"id"=>"ckeditor" ); //актрибути текстового поля
		$name='add_news';
		$data['id'] = $id;
		if(!empty($id))
			$data['news'] = $this->news_model->get($id);
		
		
		if ($this->input->post('ajax')) {
      			$this->load->view('adminka/content/add_news_view',$data);
	    }
		else
		{
			$this->display_lib->admin_page($data,$name);
		}
			
			break;
			
			case 'news_add2/'.$id:
			
		$this->load->library('ckeditor'); //загрузка бібліотеки
		$this->CI_CKEditor = new CI_CKEditor('/ckeditor/'); //шлях до папки редактора
		$this->CI_CKEditor->textareaAttributes = array( "rows" => 25, "cols" => 20,"id"=>"ckeditor" ); //актрибути текстового поля
		$name='add_news';
		$data['id'] = $id;
		if(!empty($id))
			$data['news'] = $this->news_model->get2($id);
		
		
		if ($this->input->post('ajax')) {
      			$this->load->view('adminka/content/add_news_view',$data);
	    }
		else
		{
			$this->display_lib->admin_page($data,$name);
		}
			
			break;
			case 'news_show/'.$id:
			$name='/content/show_news';
			$data =  "";
			if ($this->input->post('ajax'))
				$this->load->view('adminka/content/show_news_view');
			else
				$this->display_lib->admin_page($data,$name);
			break;
			case 'news_new/':
			if ($this->input->post('ajax'))
				$this->load->view('adminka/content/new_news_view');
			break;
				case 'page/'.$id:
				 $this->load->library('ckeditor'); //загрузка бібліотеки
				 $this->load->library('menu_lib'); //загрузка бібліотеки
				 $this->Menu_lib = new Menu_lib(); 
				 $data['page'] = $this->main_model->get($id);
				 $data['id'] = $id;
				$this->CI_CKEditor = new CI_CKEditor('/ckeditor/'); //шлях до папки редактора
				$this->CI_CKEditor->textareaAttributes = array( "rows" => 25, "cols" => 20,"id"=>"ckeditor" ); //актрибути текстового поля
				
				
			if ($this->input->post('ajax'))
			{
				$this->load->view('adminka/content/pages_view',$data);
			}
			break;
		}
		if(in_array($page,$pages))
		{
			if ($this->input->post('ajax'))	
			{
				$this->load->view('adminka/content/'.$page.'_view');
			}		
		}
			
	}
	private function delete($id)
	{
		
		if($this->input->post('ajax'))
		{
			$this->news_model->delete($id);
			echo 'Видалено';
		}
		else
		show_404();
	}
	public function pageupdate()
	{
		$this->check_admin();
		if($this->input->is_ajax_request())
		{
			$id  = $this->input->post('id');
			foreach($_POST as $Key => $Val)
			{
				$data[$Key] = $Val;
			}	
				unset ($data['sub']);
				unset ($data['id']);
				$this->main_model->updateMain('menu',$data,$id);
				echo json_encode("Новину успішно оновлено");
		}
		else
			show_404();
	}
	public function getDataGrid($namePage)//Отримання даних і вивід в jqgrid
	{
		
		$this->check_admin();
		if($this->input->is_ajax_request())
		{

			if($this->input->post('page') != NULL)$page = (int)$this->input->post('page');// Номер сторінки
			if($this->input->post('rows') != NULL)$limit = (int)$this->input->post('rows');// Кількість записів для вибору
			if($this->input->post('sidx') != NULL)$sidx = $this->input->post('sidx');// Номер элемента массиву по якому сортувати
			if($this->input->post('sord') != NULL)$sord = $this->input->post('sord');// Напрям сортування
			$where = '';
			if ($this->input->post('_search') != NULL && $this->input->post('_search') == 'true') 
			{
				$searchData = json_decode($this->input->post('filters'));
				$where = $this->generateSearchString($searchData);
				
			}
			$cont = array('photo','video','poll','news','users');
			$pages = array('service','prevision','movies','advertising');
			if(in_array($namePage,$cont))
			{
				$model = $namePage.'_model';
				$count =  $this->$model->count_grid($where);
			}
			else if(in_array($namePage,$pages))
				$count = $this->main_model->countTable($namePage);
			else
				$count = $this->news_model->count_new_grid($where);
			
			if($count != NULL)
			{
				if($count > 0 && $limit > 0)$total_pages = ceil($count/$limit);else $total_pages = 0;
				if ($page > $total_pages) $page=$total_pages;
				$start = $limit*$page - $limit;
				if($start <0) $start = 0;
				$data->page    = $page;
				$data->total   = $total_pages;
				$data->records = $count;
			}
			if(in_array($namePage,$cont))	
				$row =  $this->$model->get_grid($sidx,$sord,$start,$limit,$where);
			else if(in_array($namePage,$pages))
				$row = $this->main_model->getwhereTable($namePage,$sidx,$sord,$start,$limit,$where);
			else
				$row = $this->news_model->get_new_grid($sidx,$sord,$start,$limit,$where);
			// Строки данных для таблицы
			$i=0;
			switch($namePage)
			{
				case 'service': 
					foreach($row as $row)
					{
						$data->rows[$i]['id'] = $row['id'];
						$data->rows[$i]['cell'] = array($row['href'],$row['description']);
						$i++;
					};
					break;
					case 'poll': 
					foreach($row as $row)
					{
						$data->rows[$i]['id'] = $row['id'];
						$data->rows[$i]['cell'] = array($row['question'],$row['status'],anchor('/adminka/reset_poll/'.$row['id'], 'Reset'),$row['data']);
						$i++;
					};
					break;		
				case 'prevision':
					 foreach($row as $row)
					 {
						$data->rows[$i]['id'] = $row['id'];
						$data->rows[$i]['cell'] = array($row['prognoz']);
						$i++;
					 };
					break;
				case 'photo':
					 foreach($row as $row )
			{
				$data->rows[$i]['id'] = $row['id'];
				$data->rows[$i]['cell'] = array($row['photo_src'],$row['cat'],$row['access'],$row['title'],$row['surname'].' '.$row['name'],$row['date']);
				$i++;
			}
				break;
				case 'news':foreach($row as $row )
			{
				$data->rows[$i]['id'] = array($row['news_id']);
				$data->rows[$i]['cell'] = array($row['title_news'],$row['surname'].' '.$row['name'],$row['views'],$row['data'],$row['publish']);
				$i++;
			} break;
			case 'new_news':foreach($row as $row )
			{
				$data->rows[$i]['id'] = array($row['news_id']);
				$data->rows[$i]['cell'] = array($row['title_news'],$row['surname'].' '.$row['name'],$row['views'],$row['data'],$row['publish']);
				$i++;
			} break;
			case 'movies':foreach($row as $row )
			{
				$data->rows[$i]['id'] = array($row['id']);
				$data->rows[$i]['cell'] = array($row['name'],$row['year'],$row['cat1'],$row['cat2'],$row['cat3'],$row['cat4'],$row['cat5'],$row['cat6'],$row['cat7'],$row['cat8'],$row['cat9'],$row['ip']);
				$i++;
			} break;
			case 'users':foreach($row as $row )
			{
				$data->rows[$i]['id'] = array($row['id_user']);
				$data->rows[$i]['cell'] = array($row['surname'],$row['name'],$row['birth'],$row['email'],$row['pass'],$row['stutus'],$row['datatime']);
				$i++;
			} break;
			case 'video': foreach($row as $row )
			{
				$data->rows[$i]['id'] = array($row['id']);
				$data->rows[$i]['cell'] = array($row['href'],$row['cat'],$row['access'],$row['name'],$row['author'],$row['date']/*,$row['cat'],$row['access'],$row['name'],$row['author'],$row['date']*/);
				$i++;
			} break;
			case 'advertising':
			
				foreach($row as $row )
				{
				$data->rows[$i]['id'] = array($row['id']);
				$data->rows[$i]['cell'] = array($row['title'],$row['cat'],$row['tel'],$row['name'],$row['description'],$row['email'],$row['skype'],$row['ip_id'],$row['date']);
				$i++;
			}
			break;
			}
			
			header("Content-type: text/script;charset=utf-8");
			echo json_encode($data);	
		}
		else
			show_404();
	} 
	
	public function get_lessons($school)//Отримання розкладу уроків і запис в jqgrid
	{
		$this->check_admin();
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
	
	
	
	
	private  function generateSearchString($searchData)//Функція складного пошуку
	{
		$firstElem = true;
		$where = '';
		foreach ($searchData->rules as $rule) 
		{
			(!$firstElem)?$where .=  " ".$searchData->groupOp." ":$firstElem = false;
       		switch($rule->op)
			{ 
				case 'eq': $where .= "`".$rule->field."` = '".$rule->data."'"; break;
				case 'ne': $where .= "`".$rule->field."` != '".$rule->data."'"; break;
				case 'lt': $where .= "`".$rule->field."` < '".$rule->data."'"; break; 
				case 'le': $where .= "`".$rule->field."` <= '".$rule->data."'"; break; 
				case 'gt': $where .= "`".$rule->field."` > '".$rule->data."'"; break; 
				case 'ge': $where .= "`".$rule->field."` >= '".$rule->data."'"; break; 
				case 'bw': $where .= "`".$rule->field."` LIKE '".$rule->data."%'"; break;
				case 'bn': $where .= "`".$rule->field."` NOT LIKE '".$rule->data."%'"; break;
				case 'ew': $where .= "`".$rule->field."` LIKE '%".$rule->data."'"; break;
				case 'en': $where .= "`".$rule->field."` NOT LIKE '%".$rule->data."'"; break;
				case 'cn': $where .= "`".$rule->field."` LIKE '%".$rule->data."%'"; break;
				case 'nc': $where .= "`".$rule->field."` NOT LIKE '%".$rule->data."%'"; break;
				case 'nu': $where .= "`".$rule->field."` IS NULL"; break;
				case 'nn': $where .= "`".$rule->field."` IS NOT NULL"; break;
				case 'in': $where .= "`".$rule->field."` IN ("; $first=true;
					 foreach($rule->data as $rule)
					 {
						 (!$first)?$where .= ",":$first=false;
						 $where .= $rule; 
					 } 
					 $where .= ")";
			    break;
				case 'ni': $where = $rule->field." NOT IN (";$first=true;
					 foreach($rule->data as $rule)
					 {
						 (!$first)?$where .= ",":$first=false;
						 $where .= $rule; 
					 } 
					 $where .= ")";
			   break;
			}
		}
		return $where;
	}

	public function jqgrid_crud($namePage)//Оновлення, видалення, додавання даних з jqgrid
	{
		$this->check_admin();
		if($this->input->is_ajax_request())
		{
			foreach($_POST as $Key => $Val){$data[$Key] = $Val;}	
				unset ($data['id']);
				unset ($data['oper']);	
			$id  = (int)$this->input->post('id');
			$oper = $this->input->post('oper');
			
			switch($namePage)
			{
				case 'news': $this->news_model->delete($id);break;
				
				case 'photo':
				if($oper == 'del')	
				{
					
					$src = $this->photo_model->get_src($id);
					$this->photo_model->delete($id);
					$folders[] = FCPATH.'img/photos/gallery/'.$src['photo_src']; 
					$folders[] =  FCPATH.'img/photos/original/'.$src['photo_src']; 
					$folders[] =  FCPATH.'img/photos/thumbs/'.$src['photo_src']; 
					foreach($folders as $img)
						unlink($img);

				}
				else
					$this->photo_model->update($data,$id);
				break;
				
				case 'video':if($oper == 'del')	
					$this->video_model->delete($id);
				else
					$this->video_model->update($data,$id);
				break;
				
				case 'poll':
				if($oper == 'del')
				{
					$this->load->model('poll_model');
					$this->poll_model->delete($id);
					
				}
				else
				{
					$this->load->model('poll_model');
					$this->poll_model->active($data,$id);	
				}
				break;
		
			}
			$pages = array('movies','prevision','service','advertising');
			if(in_array($namePage,$pages))
			{
				switch($oper)
				{
					case 'add':$this->main_model->insertMain($namePage,$data);break;	
					case 'edit':$this->main_model->updateMain($namePage,$data,$id);break;
					case 'del':$this->main_model->deleteMain($namePage,$id);break;
				}
			}
		}
		else
			show_404();
	}
	public function load($page)//Завантаження сторінок(меню)
	{
		$this->check_admin();
		if($this->input->is_ajax_request())
		{
			$data = $this->main_model->get($page);
			echo json_encode($data);
		}
		else
			show_404();
	}
	public function addLes($school)//Дадавання розкладу уроків
	{
		$this->check_admin();
		if($this->input->is_ajax_request())
		{
			$day = array("class","oper","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			$i=0;
			foreach($_POST as $Val)
			{
				$data[$day[$i]] = serialize($Val);
				$i++;
			}	
				unset ($data['class']);
				unset($data['oper']);
			$oper =  $this->input->post('oper');
			if($oper == 'edit')
			{
				$class = $this->input->post('class');
				$this->main_model->updateS($class,$data,$school);
				echo json_encode("Зміни успішно внесено");
			}
			else if($oper == 'add')
			{
				$data['class']  = $this->input->post('class');
				$this->main_model->insertS($data,$school);
				echo json_encode("Добавлено");
			}
		}
		else
			show_404();
	}
	public function reset_poll($id)
	{
		$this->check_admin();
		$this->load->model('poll_model');
		$this->poll_model->resets($id);
	}
}
/* End of file adminka.php */
/* Location: ./application/controllers/adminka.php */