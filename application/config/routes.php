<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/*$a=$_SERVER['REMOTE_ADDR'];
if($a != '127.0.0.1')
{
$route['default_controller'] = "main";
$route['(:any)'] = $route['default_controller']; 
}
else
{
*/
$route['default_controller'] = "news/all";
$route['404_override'] = '';
$route['news/(:num)'] = 'news/show/$1';
$route['history'] = 'main/show/history';
$route['school1'] = 'main/show/school1';
$route['school2'] = 'main/show/school2';
$route['maps'] = 'main/show/maps';
$route['change'] = 'main/show/change';
$route['photo'] = 'photo/get/all';
$route['video'] = 'video/get';
$route['feedback'] = 'main/show/feedback';
$route['film'] = 'main/show/film';
$route['advert'] = 'main/show/advert';
$route['lessons'] = 'main/show/lessons';
$route['contact'] = 'main/show/contact';
$route['about_as'] = 'main/show/about_as';
$route['index'] = 'main/show/index';
$route['Kulebu'] = 'main/show/Kulebu';
$route['national'] = 'main/show/national';
$route['buses'] = 'main/show/buses';
$route['guta'] = 'main/show/guta';
$route['rss'] = 'news/rss';

		/*Адмінка*/
$route['adminka/root'] = 'adminka/show/root';
//}
/* End of file routes.php */
/* Location: ./application/config/routes.php */