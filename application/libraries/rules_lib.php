<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules_lib
{
    // Правила для страницы регистрации
    public $registration_rules = array(
	 /*
       array
       ('field' => 'l_name',
        'label' => 'Прізвище',
        'rules' => 'trim|required|min_length[3]|max_length[25]'        
       ),
	    array
       ('field' => 'f_name',
        'label' => 'Ім\'я',
        'rules' => 'trim|required|min_length[3]|max_length[25]'        
       ),
	      array
       ('field' => 'day',
        'label' => 'день',
        'rules' => 'is_natural_no_zero'        
       ),
	      array
       ('field' => 'mounth',
        'label' => 'місяць',
        'rules' => 'is_natural_no_zero'        
       ),
	      array
       ('field' => 'year',
        'label' => 'рік',
        'rules' => 'is_natural_no_zero'        
       ),
	   */
       array
       ('field' => 'email',
        'label' => 'Ваш Email',
        'rules' => 'trim|required|valid_email|is_unique[users_auth.email]|max_length[80]'        
       )/*,
       array
       ('field' => 'pass',
        'label' => 'Пароль',
        'rules' => 'trim|required|alpha_dash|min_length[6]|max_length[50]'        
       ),
       array
       ('field' => 'sicret',
        'label' => 'секрет',
        'rules' => 'trim|required|is_natural_no_zero|alpha_dash|max_length[35]'             
       ),
	    array
       ('field' => 'answ',
        'label' => 'відповідь',
        'rules' => 'trim|required|max_length[100]'        
       )*/
	   
    );
    
    //Правила для авторизації
    public $login_rules = array(
       array
       ('field' => 'email',
        'label' => 'Логин (Email)',
        'rules' => 'trim|required|valid_email|max_length[80]'        
       ),
       array
       ('field' => 'pass',
        'label' => 'Пароль',
        'rules' => 'trim|required|alpha_dash|min_length[6]|max_length[50]'             
       )          
    );  
	//Правила для відновлення паролю
	 public $pass_recover_rules = array(
       array
       ('field' => 'email',
        'label' => 'Логин (Email)',
        'rules' => 'trim|required|valid_email|max_length[80]'        
       )       
    ); 
	  public $ajax = array(
	 
       array
       ('field' => 'name',
        'label' => 'Логин (Email)',
        'rules' => 'trim|required||min_length[3]'        
       ) 
	   ); 
}