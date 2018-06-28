<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Poll_lib
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->lang->load('poll');	
		$this->CI->load->model('poll_model');
	}
	public function get_poll()//Перевірка на cookie
	{
		$row = $this->CI->poll_model->get_id();
		if($this->CI->input->cookie('poll'))//Якщо є кукі
		{
			
			$value = $this->CI->input->cookie('poll');	
			if($value!=$row->id)//Якщо це нове голосування
			{
				delete_cookie('poll');
				return $this->get_poll_form();
			}
			else
				return $this->get_result();
		}
		else//Інакше перевірка на IP
		{
			$ip = unserialize($row->ip);
			$ip_user = $this->CI->input->ip_address();
			if($ip  == false)
				return	$this->get_poll_form();
			else
			{
				if(!in_array($ip_user,$ip))
					return	$this->get_poll_form();
				else
				{
					$cookie['name'] =   'poll';
					$cookie['value'] =  $row->id;
					$cookie['expire'] =   time() + 1*30*24*60*60;//1 місяць
					$this->CI->input->set_cookie($cookie);
					return	$this->get_result();
				}
			}
			
		}
		
	}
	public function get_poll_form()
	{
		$row = $this->CI->poll_model->get_poll();
		$answers = unserialize($row->answers);
		$f_open = array('id' => 'pollForm');
		$poll_form = form_open('/poll/set_poll',$f_open);
		$poll_form .= "<p>".$row->question."</p>";
		foreach($answers as $answer)
		{
			
			$poll_form .= "<div class='answer'>".form_radio('answer', $answer);
			$poll_form .= form_label($answer, $answer).'</div>';
		}
		$poll_form .= '<button type="submit" name="sub">Голосувати</button>';
		$poll_form .= form_close();
		$data['poll_form'] = $poll_form;
		return $data;
	}
	
	public function get_result()//Отримання результату
	{
	
		$row = $this->CI->poll_model->get_result();
		$answers = unserialize($row->answers);
		$votes = unserialize($row->votes);
		if($votes != FALSE)
		{
			$total_votes = 0;
			foreach ($votes as $val)//Підрахунок загальної кількості
				$total_votes += $val;
		}
		else
			$total_votes = 0;
		if($votes != FALSE)
		foreach($answers  as $key => $val)
			if(!array_key_exists($key, $votes))
				$votes[$key] = 0; 
			
		
		(is_array($votes)) ? arsort($votes) : '';
		$question = $row->question;
		
		 	$results_html  = "<div id='poll-results'><h3>$question</h3>\n<ul>";  	
		if($votes != FALSE)
		{
			foreach($votes  as $key => $val)
			{	
				if(array_key_exists($key, $votes))
				{
					$percent = round(($val/$total_votes)*100);
					$results_html .= "<li>$answers[$key] <small>($percent%, $val голосів)</small><div title='$answers[$key]($percent%, $val голосів)' style='width:$percent%'></div></li>";  	
				}
				else
				{
					 $percent = 0;
					$results_html .= "<li>$answers[$key] <small>($percent%, $val голосів)</small><div title='$answers[$key]($percent%, $val голосів)' style='width:$percent%'></div></li>"; 					
				}
			}
		}
		else
		{
			for($i=0; $i<count($answers);$i++)
			{
				$percent = 0;
				$results_html .= "<li>$answers[$i] <small>($percent%, 0 голосів)</small><div title='$answers[$i]($percent%, 0 голосів)' style='width:$percent%'></div></li>"; 	
			}
		}				
		$results_html .= "</ul><p>Всього проголосувало: ". $total_votes ."</p></div>";
		return $results_html;
		
	}	
	public function get_all_polls($sidx,$sord,$start,$limit,$where)
	{
		return $this->CI->poll_model->get_all_polls($sidx,$sord,$start,$limit,$where);
	}
	
	/**
	 *  Set poll status (Admin)
	 *  @params integer $id
	 */
	public function set_poll_status($id)
	{
		$this->CI->db->update('polls', array('status' => 'inactive'));
		$this->CI->db->update('polls', array('status' => 'active'), array('id' => $id));
	}
	
	/**
	 *  Save new poll (Admin)
	 *  @params array $datas
	 *
	 */
	 public function count_all()
	{
		return	$this->CI->poll_model->count_all();
	}
	public function save_new_poll($datas)//Створення нового опитування
	{
		$data = array(
			'question' => $datas['title'],
			'answers' => serialize($datas['options']),
			'votes' => '',
			'ip' => '',
			'status' => 'inactive'
		);
		$this->CI->poll_model->add($data);
	}	
	
        /**
	 *  Reset poll values (Admin)
	 *  @params integer $id
	 *
	 */
	
}