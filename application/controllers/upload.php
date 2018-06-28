<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends CI_Controller
{
	protected $path_img_upload_folder;
	protected $path_img_gallery_upload_folder;
	protected $path_img_thumb_upload_folder;
	protected $path_url_img_upload_folder;
	protected $path_url_img_gallery_upload_folder;
	protected $path_url_img_thumb_upload_folder;
	protected $delete_img_url;
	function __construct()
	{
		parent::__construct();
		$this->load->library('image_lib');
		//Set relative Path with CI Constant
		$this->setPath_img_upload_folder(FCPATH.'/img/photos/original/');
		$this->setPath_img_gallery_upload_folder(FCPATH.'/img/photos/gallery/');
		$this->setPath_img_thumb_upload_folder(FCPATH.'/img/photos/thumbs/');
		//Delete img url
		$this->setDelete_img_url(base_url().'upload/deleteImage/original/');
		//Set url img with Base_url()
		$this->setPath_url_img_upload_folder(base_url()."img/photos/original/");
		$this->setPath_url_img_gallery_upload_folder(base_url()."img/photos/gallery/");
		$this->setPath_url_img_thumb_upload_folder(base_url()."img/photos/thumbs/");
		$this->load->model('photo_model');
	}
	public function index()
	{
		show_404();
	}
	public function upload_img()
	{
		$config['upload_path'] = $this->getPath_img_upload_folder();
		$config['encrypt_name'] = true;
		$config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG';
		$config['max_size'] = '50000';
		$this->load->library('upload', $config);
		if ($this->do_upload())
		{
			$data = $this->upload->data();
			$s =  $data['file_size'];//Розмір оригінального файла
			//Створення картинки для галареї
			 $gallery = array(
			'image_library' => 'gd2',
			'file_name' =>  $data['file_name'],
			'source_image' => $this->getPath_img_upload_folder().$data['file_name'],
			'new_image' => $this->getPath_img_gallery_upload_folder(),
			'create_thumb' => TRUE,
			'thumb_marker' => false,
			'maintain_ration' => true,
			'width' => 900,
			'height' => 600
		  	);
			$this->image_lib->initialize($gallery);
			$this->image_lib->resize();
			$this->image_lib->clear();
			//Створення міні-картинки
		     $mini = array(
			'image_library' => 'gd2',
			'file_name' =>  $data['file_name'],
			'source_image' =>  $this->getPath_img_gallery_upload_folder().$data['file_name'],
			'new_image' => $this->getPath_img_thumb_upload_folder(),
			'quality' => '100%',
			'create_thumb' => true,
			'thumb_marker' => false,
			'maintain_ration' => FALSE,
			'master_dim' =>  'auto',
			'width' => 215,
			'height' => 130
		  	);
			$this->image_lib->initialize($mini);
			$this->image_lib->resize();
			$this->image_lib->clear();
			//Водяний знак на gallery
			$Watermarking = array(
			'source_image' => $this->getPath_img_gallery_upload_folder().$data['file_name'],
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
			//Get info 
			$info = new stdClass();
			$info->name =$data['file_name'];
			$info->size = $s;
			$info->type = $data['file_type'];
			$info->url = $this->getPath_url_img_gallery_upload_folder().$data['file_name'];
			$info->thumbnail_url = $this->getPath_url_img_thumb_upload_folder().$data['file_name']; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
			$info->delete_url = $this->getDelete_img_url().$data['file_name'];
			$info->delete_type = 'DELETE';


			//Return JSON data
			if (IS_AJAX)
			{   //this is why we put this in the constants to pass only json data
			$photo = array();
				$photo['cat'] = 4;
				if ($this->session->userdata('logged_in') === true)
				{
					$photo['author'] = $this->session->userdata('id_user');
					$photo['access'] = 0;
				}
				else
				{
					$photo['author'] = $this->input->ip_address();
					$photo['access'] = 2;
				}
				
				$photo['photo_src'] = $data['file_name'];
				$photo['title'] = '';
				$photo['date'] = date('Y-m-d H:i:s');
				$this->photo_model->add($photo);
				echo '{"files":'.json_encode(array($info)).'}';
				//Запис в базу
				
			//this has to be the only the only data returned or you will get an error.
			//if you don't give this a json array it will give you a Empty file upload result error
			//it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
			}
			else
			{   // so that this will still work if javascript is not enabled
				$file_data['upload_data'] = $this->upload->data();
				//echo '{"files":'.json_encode(array($info)).'}';
				var_dump($info);
			}
		}
		else
		{
		// the display_errors() function wraps error messages in <p> by default and these html chars don't parse in
		// default view on the forum so either set them to blank, or decide how you want them to display.  null is passed.
		$error = array('error' => $this->upload->display_errors('',''));
		echo '{"files":'.json_encode(array($error)).'}';
		//var_dump($error);
		}
	}
	//Function for the upload : return true/false
	private function do_upload()
	{
		if (!$this->upload->do_upload())
		{
			return false;
		}
		else
		{
			//$data = array('upload_data' => $this->upload->data());
			return true;	
		}
	}
	//Function Delete image
	public function deleteImage()
	{
		//Get the name in the url
		$file = $this->uri->segment(4);
		
		$success = unlink($this->getPath_img_upload_folder().$file);
		$susses_ga = unlink($this->getPath_img_gallery_upload_folder().$file);
		$success_th = unlink($this->getPath_img_thumb_upload_folder().$file);
		//info to see if it is doing what it is supposed to	
		$info = new stdClass();
		$info->sucess = $success;
		$info->path = $this->getPath_url_img_upload_folder().$file;
		$info->file = is_file($this->getPath_img_upload_folder().$file);
		if (IS_AJAX)
		{//I don't think it matters if this is set but good for error checking in the console/firebug
			$this->photo_model->delete_user($file);
			echo json_encode(array($info));
		}
		else
		{
			//here you will need to decide what you want to show for a successful delete
			var_dump($file);
		}
	}


	//Load the files
	public function get_files()
	{
		$this->get_scan_files();
	}

	//Get info and Scan the directory
	public function get_scan_files()
	{
		$file_name = isset($_REQUEST['file']) ?
				basename(stripslashes($_REQUEST['file'])) : null;
		if ($file_name)
		{
			$info = $this->get_file_object($file_name);
		}
		else
		{
			$info = $this->get_file_objects();
		}
		header('Content-type: application/json');
		echo json_encode($info);
	}

	protected function get_file_object($file_name)
	{
		$file_path = $this->getPath_img_upload_folder() . $file_name;
		if (is_file($file_path) && $file_name[0] !== '.')
		{

			$file = new stdClass();
			$file->name = $file_name;
			$file->size = filesize($file_path);
			$file->url = $this->getPath_url_img_upload_folder() . rawurlencode($file->name);
			$file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
			//File name in the url to delete 
			$file->delete_url = $this->getDelete_img_url() . rawurlencode($file->name);
			$file->delete_type = 'DELETE';
			
			return $file;
		}
		return null;
	}

	//Scan
	protected function get_file_objects()
	{
		return array_values(array_filter(array_map(
			array($this, 'get_file_object'), scandir($this->getPath_img_upload_folder())
		)));
	}
	// GETTER & SETTER 
	public function getPath_img_upload_folder()
	{
		return $this->path_img_upload_folder;
	}
	public function setPath_img_upload_folder($path_img_upload_folder)
	{
		$this->path_img_upload_folder = $path_img_upload_folder;
	}
	public function getPath_img_gallery_upload_folder()
	{
		return $this->path_img_gallery_upload_folder;
	}
	public function setPath_img_gallery_upload_folder($path_img_gallery_upload_folder)
	{
		$this->path_img_gallery_upload_folder = $path_img_gallery_upload_folder;
	}
	public function getPath_img_thumb_upload_folder()
	{
		return $this->path_img_thumb_upload_folder;
	}
	public function setPath_img_thumb_upload_folder($path_img_thumb_upload_folder)
	{
		$this->path_img_thumb_upload_folder = $path_img_thumb_upload_folder;
	}
	public function getPath_url_img_upload_folder()
	{
		return $this->path_url_img_upload_folder;
	}
	public function setPath_url_img_upload_folder($path_url_img_upload_folder)
	{
		$this->path_url_img_upload_folder = $path_url_img_upload_folder;
	}
	public function getPath_url_img_gallery_upload_folder()
	{
		return $this->path_url_img_gallery_upload_folder;
	}
	public function setPath_url_img_gallery_upload_folder($path_url_img_gallery_upload_folder)
	{
		$this->path_url_img_gallery_upload_folder = $path_url_img_gallery_upload_folder;
	}
	public function getPath_url_img_thumb_upload_folder()
	{
		return $this->path_url_img_thumb_upload_folder;
	}
	public function setPath_url_img_thumb_upload_folder($path_url_img_thumb_upload_folder)
	{
		$this->path_url_img_thumb_upload_folder = $path_url_img_thumb_upload_folder;
	}
	public function getDelete_img_url()
	{
		return $this->delete_img_url;
	}
	public function setDelete_img_url($delete_img_url)
	{
		$this->delete_img_url = $delete_img_url;
	}
}