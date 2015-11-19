<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $route['api/timetable/(:num)'] 									= 'backend/api/timetable/id/$1'; 
// $route['api/timetable/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] 			= 'backend/api/timetable/id/$1/format/$3$4'; 

$route['backend/(:any)/building'] 								= 'backend/building/index';
$route['backend/(:any)/building/preview/(:num)']				= 'backend/building/edit/$1';

$route['backend/(:any)/room']  									= 'backend/room/index';
$route['backend/(:any)/room/preview/(:num)']					= 'backend/room/edit/$l';

$route['backend/(:any)/lecturer'] 								= 'backend/lecturer/index';
$route['backend/(:any)/lecturer/preview/(:num)']				= 'backend/lecturer/edit/$l';

$route['backend/(:any)/class'] 									= 'backend/classes/index';
$route['backend/(:any)/class/preview/(:num)']					= 'backend/class/edit/$l';

$route['backend/(:any)/course']							 		= 'backend/course/index';
$route['backend/(:any)/course/preview/(:num)']					= 'backend/course/edit/$l';

$route['backend/(:any)/user-mgr'] 								= 'backend/home/list_all';
$route['backend/(:any)/user-mgr/groups']						= 'backend/home/groups';
$route['backend/(:any)/user-mgr/ban']							= 'backend/home/ban';
$route['backend/(:any)/user-mgr/profile']						= 'backend/home/profile';



$route['backend/(:any)/dashboard']	 							= 'backend/home/index';
$route['backend/dashboard'] 									= 'backend/home/index';
$route['backend/(:any)/logout'] 								= 'backend/home/logout';
$route['test'] 													= 'test/index';

$route['backend/(:any)/settings/backup'] 						= 'backend/home/webapp/index';
$route['backend/(:any)/accounts'] 								= 'backend/home/account/index';

$route['api/timetable']											= 'api/timetable';
$route['api/timetable/(:num)'] 									= 'api/timetable/id/$1'; 

$route['backend/(:any)/timetable']								= 'backend/timetable/index';

$route['index'] 												= 'home/index';
$route['default_controller'] 									= 'home';
$route['404_override'] 											= '';
$route['translate_uri_dashes'] 									= FALSE;