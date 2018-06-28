<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
class Menu_lib
{
	private $_category_arr = array(); 
	private $temp = 0; 
	private $CI;
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('main_model');
		$this->CI->_category_arr = $this->getCategory('');
		$this->CI->_category_Admin = $this->getCategory('admin');
	}
	private function getCategory($model='') 
	{ 
		if($model=='')
   			$result= $this->CI->main_model->getMenu($model);
		else
			$result= $this->CI->main_model->getMenu($model);
        $return = array(); 
        foreach ($result as $value) 
		{ 
            $return[$value['parent_id']][] = $value; 
        } 
        return $return; 
    } 
	public function outTree($parent_id, $level) 
	{ 
        if (isset($this->CI->_category_arr[$parent_id]))
		{	
            foreach ($this->CI->_category_arr[$parent_id] as $value) 
			{
				if($level)
				{
					if($this->temp==0){echo "<ul>";$this->temp++;}
					echo '<li><a href="'.base_url().$value['menu_id'].'" >'.$value['name'];
					if($value['new']){echo " <span style=\"color:red\">нове</span></a>";}
					echo "</li>";
				}
				else
				{
					if($this->temp){echo "</ul></li>"; $this->temp--;}
					if($value['menu_id']=="submenu")
						echo '<li class="submenu">'.$value['name'].' <img src="/img/popup.png" />';
					else
						echo '<li><a href="'.base_url().$value['menu_id'].'" >'.$value['name'];
					if($value['new']){echo " <span style=\"color:red\">нове</span>";}
					if($value['menu_id']!='submenu'){echo "</a></li>";}		
				}
                $level++; 
                $this->outTree($value['id'], $level); 
                $level--;
            } 
        } 
    }	
    public function outTreeAdmin($parent_id, $level) 
	{ 
        if (isset($this->CI->_category_Admin[$parent_id]))
		{	
            foreach ($this->CI->_category_Admin[$parent_id] as $value) 
			{
				echo '<div style="margin-left:'.($level * 25). 'px;">';
				if($value['menu_id']=="submenu")
				echo '<span class="id_page">' .$value['id'] .'</span>'. $value['name'].'</div>'; 	
				else echo '<a href="'.base_url().'adminka/load/'.$value['menu_id'].'"><span class="id_page">' .$value['id'] .'</span>'. $value['name'] . '</a></div>'; 	
                $level++; 
                $this->outTreeAdmin($value['id'], $level); 
                $level--;
            } 
        } 
    }	
}