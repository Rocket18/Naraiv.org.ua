<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller
{

	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('comments_model');
	}
	
	private function check_captcha()
	{
		$captcha  = $this->input->post('captcha');
		$data = ($captcha == $this->session->userdata('code')) ? 'true': 'false';
		echo $data;
	}

	private function add()
	{
		$data = array();
		$data['author'] = $this->input->post('author'); 
		$data['email'] = $this->input->post('email'); 
		$data['comment_text'] = $this->input->post('text');
		$data['matterials_id'] = $this->input->post('id_page');
		$data['data'] = date('Y-m-d H:i:s');
		$aa = "Ваш коментар успішно добавлено";
		$this->comments_model->add_comment($data);
		
		echo json_encode($aa);
		
		
		
	}
	
}

/* End of file comments.php */
/* Location: ./application/controllers/comments.php */
