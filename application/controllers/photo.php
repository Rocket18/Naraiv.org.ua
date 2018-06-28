<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('photo_model');
		$this->load->library('breadcrumb_lib');
		$this->load->library('menu_lib'); //загрузка бібліотеки
		$this->load->library('poll_lib');
		$this->load->library('auth_lib');

	}
	public function index()
	{
		show_404();
	}
	public function get($category,$start_from = '')
	{
		$this->Menu_lib = new Menu_lib();
		$this->load->library('pagination');
		$this->load->library('pagination_lib');
		if ($this->session->userdata('logged_in') === true)
		{
			$id = $this->session->userdata('id_user');
			$data['ses'] = "isLogin";
			$this->load->library('auth_lib');
			$data['userMenu'] = $this->auth_lib->userMenu();
		}
		else
			$id = '';
		switch($category)
		{
			case 'all': $data['cat'] = '';break;
			case 'school': $data['cat'] = '0';break;
			case 'people': $data['cat'] = '1';break;
			case 'nature': $data['cat'] = '2';break;
			case 'club': $data['cat'] = '3';break;
			case 'other': $data['cat'] = '4';break;
			default:$cat = '';	
		}
		$total = $this->photo_model->count_all($id,$data['cat']);
		$limit = 24;
		$settings = $this->pagination_lib->get_photo($total,$limit,$start_from,$category);
		$this->pagination->initialize($settings); 
		$data['poll'] = $this->poll_lib->get_poll();
		$data['photo'] = $this->photo_model->get_photo($limit,$start_from,$id,$data['cat']);
		$data['css'][] = '<link rel="stylesheet" href="/css/photo.css">';
		$data['css'][] = '<link rel="stylesheet" href="/css/prettyPhoto.css">';
		$data['script'][] = '<script type="text/javascript" src="/js/jquery.quicksand.js"></script>';
		$data['script'][] = '<script type="text/javascript" src="/js/script.js"></script>';
		$data['script'][] = '<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script>';
		$data['title']='Фотоальбом';
		$data['page_nav'] = $this->pagination->create_links();
		$data['description'] = 'Фотоальбом села Нараїв';
		$data['keywords'] = 'фото';
		$data['last_news'] =  $this->news_model->last_news();//Останні новини 
		$data['popular_news'] = $this->news_model->popular_news();////Популярні новини
		$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
		$name = 'content/photo';
		$this->display_lib->page($data,$name);	
	}
	public function ckupload()
	{
			$callback = $_GET['CKEditorFuncNum'];

			$field = 'upload';
			$error = '';
			$config['upload_path'] =  FCPATH.'/uploads/'; // шляз до папки 
			$config['encrypt_name'] = true;
			$config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG';
			$config['max_size'] = '50000';
			$this->load->library('upload', $config);
			if($this->upload->do_upload($field))
			{
				$data = $this->upload->data();
				
				$this->load->library('image_lib');
				$size = array(
			'image_library' => 'gd2',
			'file_name' =>  $data['file_name'],
			'source_image' => FCPATH.'/uploads/'.$data['file_name'],
			'new_image' => FCPATH.'/img/news/all/',
			'create_thumb' => TRUE,
			'thumb_marker' => false,
			'maintain_ration' => true,
			'width' => 650,
			'height' => 400
		  	);
			$this->image_lib->initialize($size);
			$this->image_lib->resize();
			$this->image_lib->clear();
			$Watermarking = array(
			'source_image' => FCPATH.'/img/news/all/'.$data['file_name'],
			'wm_text' => 'http://naraiv.org.ua',
			'wm_font_path' => './system/fonts/texb.ttf',
			'wm_font_size' => '18',
			'wm_font_color' => 'FFFFFF',
			'wm_vrt_alignment' => 'bottom',
			'wm_hor_alignment' => 'right',
			'wm_vrt_offset' => -15,
			'wm_hor_offset' => -15
			);
			$this->image_lib->initialize($Watermarking); 
			$this->image_lib->watermark();
			$http_path = '/img/news/all/'.$data['file_name'];	
			}
			 else
			{
			//$error = 'Сталася помилка'; 
			$error = $this->upload->display_errors('','');
			$http_path = '';
			}
			unlink(FCPATH.'/uploads/'.$data['file_name']);
			echo "<script type='text/javascript'>// <![CDATA[
			window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );
			// ]]></script>";
	}
	public function upload_file()
	{
	   $status = "";
	   $msg = "";
	   $file_element_name = 'userfile';
	   $config['upload_path'] = './uploads';
	   $config['allowed_types'] = 'gif|jpg|png';
	   $config['max_size']  = 1024 * 8;
	   $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config);
 
      if (!$this->upload->do_upload($file_element_name)) 
	  {
         $status = 'error';
         $msg = $this->upload->display_errors('', '');
      } 
	  else 
	  {
         $data = $this->upload->data();
		  $mini = array(
			'image_library' => 'gd2',
			'file_name' =>$data['file_name'],
			'source_image' => './uploads/'.$data['file_name'],
			'new_image' => './img/news/',
			'create_thumb' => true,
			'thumb_marker' => false,
			'maintain_ration' => false,
			'width' => 450,
			'height' => 190
		  	);
			$this->load->library('image_lib');
			$this->image_lib->initialize($mini);
			$this->image_lib->resize();
			
			$msg = $data['file_name'];
   	}
  echo json_encode(array('status' => $status, 'msg' => $msg));	  
	}
	
	private function delete_file()
	{
 		unlink($this->input->post('src'));
		echo json_encode($this->input->post('src'));
	}

	public function add()
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
		$data['title']='Додати фото';
		$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
		$data['description'] = 'Завантажейте фотографії на сайт с.Нараїв';
		$data['keywords'] = 'фото,upload';
		$data['css'][] = '<link rel="stylesheet" href="/css/bootstrap.min.css">';	
		$data['css'][] = '<link rel="stylesheet"  href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">';
		$data['css'][] = '<link rel="stylesheet" href="/css/jquery.fileupload-ui.css">';
		$data['script'][] = '<script src="/js/File Upload/jquery.ui.widget.js"></script>';
		$data['script'][] = '<script src="http://blueimp.github.com/JavaScript-Templates/js/tmpl.min.js"></script>';
		$data['script'][] = '<script src="http://blueimp.github.com/JavaScript-Load-Image/js/load-image.min.js"></script>';
		$data['script'][] = '<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>';
		$data['script'][] = '<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>';
		$data['script'][] = '<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/jquery.iframe-transport.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/jquery.fileupload.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/jquery.fileupload-fp.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/jquery.fileupload-ui.js"></script>';
		$data['script'][] = '<script src="/js/File Upload/main.js"></script>';
		$name = 'content/photo_add';
		$this->display_lib->page($data,$name);
			
	}
	public function edit()
	{
		$this->Menu_lib = new Menu_lib(); 
		if($this->auth_lib->check_users_logIn())
		{
		
			$id_user = $this->session->userdata('id_user');
			$data['ses'] = "isLogin";
			$data['userMenu'] = $this->auth_lib->userMenu();
			$data['poll'] =  $this->poll_lib->get_poll();
			$data['title']='Додати фото';
			$data['breadcrumb'] = $this->breadcrumb_lib->get_breadcrumbs();	
			$data['description'] = 'Завантажейте фотографії на сайт с.Нараїв';
			$data['keywords'] = 'фото,upload';
			$data['css'][] = '<link rel="stylesheet" href="/css/photo.css">';
			$data['css'][] = '<link rel="stylesheet" type="text/css" media="screen" href="/css/ui.jqgrid.css" mce_href="css/ui.jqgrid.css" />';
			$data['script'][] = '<script src="/js/jquery.jqGrid.min.js"></script>';
			$data['script'][] = '<script src="/js/grid.loader.js"></script>';
			$data['script'][] = '<script src="/js/datapicker.js"></script>';
			$name = 'content/photo_edit';
			$this->display_lib->page($data,$name);	
		}
		else
			show_404();
		
	}
	public function photo_jqgrid()
	{
		if($this->auth_lib->check_users_logIn())
		{
			$id_user = $this->session->userdata('id_user');
			if($this->input->post('page') != NULL)$page = (int)$this->input->post('page');// Номер сторінки
			if($this->input->post('rows') != NULL)$limit = (int)$this->input->post('rows');// Кількість записів для вибору
			if($this->input->post('sidx') != NULL)$sidx = $this->input->post('sidx');// Номер элемента массиву по якому 
			$sord = $this->input->post('sord');// Напрям сортування
			$where = '';
			if ($this->input->post('_search') != NULL && $this->input->post('_search') == 'true') 
			{
				$searchData = json_decode($this->input->post('filters'));
				$where = $this->generateSearchString($searchData);
			}
			$count =  $this->photo_model->count_where($id_user);
			
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
			$row = $this->photo_model->get_grid($sidx,$sord,$start,$limit,$where,$id_user);
			$i=0;
			foreach($row as $row )
			{
				$data->rows[$i]['id'] = $row['id'];
				$data->rows[$i]['cell'] = array($row['photo_src'],$row['cat'],$row['access'],$row['title'],$row['date']);
				$i++;
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
	public function jqgrid_crud()
	{
		if($this->input->is_ajax_request())
		{
			if($this->auth_lib->check_users_logIn())
			{
				foreach($_POST as $Key => $Val){$data[$Key] = $Val;}	
				unset ($data['id']);
				unset ($data['oper']);	
				$id  = (int)$this->input->post('id');
				$oper = $this->input->post('oper');	
				if($oper == 'edit')
					$this->photo_model->update($data,$id);
				else
				{
					$src = $this->photo_model->get_src($id);
					$this->photo_model->delete($id);
					$folders[] = FCPATH.'img/photos/gallery/'.$src['photo_src']; 
					$folders[] =  FCPATH.'img/photos/original/'.$src['photo_src']; 
					$folders[] =  FCPATH.'img/photos/thumbs/'.$src['photo_src']; 
					foreach($folders as $img)
						unlink($img);
					
				}
			}
		}
		else
			show_404();
	}
}