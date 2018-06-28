<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb_lib 
{
	public $breadcrumb_main = '<a href = "http://www.naraiv.org.ua">Головна</a>';
	public function get_breadcrumbs()
	{    
		$CI =& get_instance(); 
		$segment = $CI->uri->segment(1);   
		 switch ($segment)
		{
			case 'news':                              
			$breadcrumb = $CI->uri->segment(2);                
			switch ($breadcrumb)
			{
				case 'all':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;
				$data['breadcrumb']['hardcoded_segment'] = 'Новини';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Всі новини';
				return $data['breadcrumb'];         
				break; 
				case 'all_where':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;
				$data['breadcrumb']['hardcoded_segment'] = 'Новини';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Мої новини';
				break;
				case 'add_news':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;
				$data['breadcrumb']['hardcoded_segment'] = 'Новини';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Додати новину';
				return $data['breadcrumb'];         
				break;
				default:
				$CI->load->model('breadcrumb_model');         
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Новини';           
				$data['breadcrumb']['breadcrumb_arrow'] = $CI->breadcrumb_model->title_news($breadcrumb);
				return $data['breadcrumb']; 
				break;   
			} 
				case 'users':                              
			$breadcrumb = $CI->uri->segment(2);                
			switch ($breadcrumb)
			{
				case 'about_me':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Моя сторінка';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Про мене';
				return $data['breadcrumb']; 
				break;
				
				case 'add_inf':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Моя сторінка';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Додати інформацію';
				return $data['breadcrumb']; 
				break;
				case 'add_news':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Мої новини';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Додати|Редагувати';
				return $data['breadcrumb']; 
				break;
				
			}
			
				case '':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Новини';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Всі новини';
				return $data['breadcrumb']; 
				break;
				
				case 'index':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Дякуємо що відвідуєте наш сайт';
				return $data['breadcrumb']; 
				break;  
				case 'Kulebu':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Кулебська трагедія';
				return $data['breadcrumb']; 
				break; 
				
				case 'guta':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Урочище Гута';
				return $data['breadcrumb']; 
				break; 
				
				case 'national':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Події з історії';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Народний рух України';
				return $data['breadcrumb']; 
				break;  
				
				case 'film':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Фільми варті перегляду';
				return $data['breadcrumb']; 
				break;  
				
				case 'buses':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Розклад автобусів';
				return $data['breadcrumb']; 
				break;  
				
				case 'history':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Історія';
				return $data['breadcrumb']; 
				break;
				
				case 'school1':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Освіта';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Нараївська ЗОШ I-IIIст.';
				return $data['breadcrumb']; 
				break; 
				
				case 'school2':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Освіта';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Нараївська ЗОШ I-IIст.';
				return $data['breadcrumb']; 
				break; 
				
				case 'lessons':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Освіта';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Розклад занять';
				return $data['breadcrumb']; 
				break; 
				
				case 'maps':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Ми на карті';
				return $data['breadcrumb']; 
				break;
				
				
				case 'feedback':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Зворотній зв\'язок';
				return $data['breadcrumb']; 
				break; 
				 
				case 'video':
				$breadcrumb = $CI->uri->segment(2);                
				switch ($breadcrumb)
				{
					case 'add':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Відеозаписи';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Додати';
				return $data['breadcrumb']; 
					break;
					case '':
					$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
					$data['breadcrumb']['hardcoded_segment'] = 'Відео';
					return $data['breadcrumb']; 
				}
					break;

				
				case 'advert':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Оголошення';
				return $data['breadcrumb']; 
				break;

				
				case 'photo':                              
			$breadcrumb = $CI->uri->segment(2);                
			switch ($breadcrumb)
			{
				case 'add':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Фотографії';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Завантажити';
				return $data['breadcrumb']; 
				break;
				
				case 'edit':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Мої фотографії';
				$data['breadcrumb']['breadcrumb_arrow'] = 'Редагувати';
				return $data['breadcrumb']; 
				break;
				
				case '':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Фотоальбом';
				return $data['breadcrumb']; 
				break;
				
				
			}
				case 'contact':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Контакти';
				return $data['breadcrumb']; 
				break;
				
				case 'about_as':
				$data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
				$data['breadcrumb']['hardcoded_segment'] = 'Про нас';
				return $data['breadcrumb']; 
				break;                   
		}     
	}       
}