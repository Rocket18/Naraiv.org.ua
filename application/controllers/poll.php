<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 *	Example controller for /poll library
 *
 */
class Poll extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('poll_lib');
		$this->load->model('poll_model');
		$this->form_validation->set_error_delimiters('<dd class="error">', '</dd>');
	}
	public function index()
	{
		redirect(base_url());
	}
	public function set_poll()
	{
		if($this->input->is_ajax_request())
		{
			$row  = $this->poll_model->set_poll();
			$ip_user = $this->input->ip_address();
			$ip = unserialize($row->ip);
			$ip[] = $ip_user;
			$vote = $this->input->post('answer');
			$answers = unserialize($row->answers);
			$key = array_search($vote, $answers);//Пошук ключа
	
			$votes = unserialize($row->votes);
			if($votes != FALSE)
			{
				if (array_key_exists($key, $votes)) 
					$actual_vote = $votes[$key] + 1;
				else
					$actual_vote =  1;	
			}
			else
				$actual_vote =  1;	
			$votes[$key] = $actual_vote;
			$data['votes'] = serialize($votes);
			$data['ip'] = serialize($ip);
			$this->poll_model->updates($data);
			$cookie['name'] =   'poll';
			$cookie['value'] =  $row->id;
			$cookie['expire'] =   time() + 1*30*24*60*60;//1 місяць
			$this->input->set_cookie($cookie);
			echo $data['poll'] =  $this->poll_lib->get_result();
		}
	}
	
	public function poll_result()
	{
		$data = $this->poll_lib->get_result();
		$data .=  '<div id="backToPoll" >Голосувати</div>';
		$data .= '<script>$("#backToPoll").click(function(){
			$("#poll-results").remove();
			$(this).remove();
			 $("#pollForm").fadeIn("slow");
	
});</script>';
			echo $data;
		
		
	}
	
	/**
	 *	Polls management
	 *
	 */
	public function admin_polls()
	{
		$data['polls'] = $this->poll_lib->get_all_polls();
		$this->load->view('adminka/content/all_polls_view', $data);
	}
	
	/**
	 *	Add new poll
	 *
	 */
	public function create()//Створення нового опитування
	{
		$this->form_validation->set_rules('title', 'назва опитування', 'required');
		$this->form_validation->set_rules('options[]', 'варіанти відповідей', 'required');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		if ($this->input->is_ajax_request())
		{
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array('fail' => TRUE, 'error_messages' => validation_errors()));
			}
			else
			{
				$data['data'] = date("Y-m-d H:i:s");
				$data['title'] = $this->input->post('title');
				$data['options'] = $this->input->post('options') ;
				$this->poll_lib->save_new_poll($data);
				echo json_encode(array('fail' => FALSE));
			}
		}
	}
	public function getEdit($id)
	{
		if($this->input->is_ajax_request())
		{
			$poll = (int)$id;
			$data = $this->poll_model->getPoll($poll);
			$answers = unserialize($data['answers']);
			$count = count($answers);
			$row['question'] = $data['question'];
			$row['answers'] = $answers;
			$row['count'] = $count;
			echo json_encode($row);
				
		}

		
	}
	public function set_poll_status($id)
	{
		$this->poll_lib->set_poll_status($id);
		redirect('/poll/admin_polls');
	}

	
}