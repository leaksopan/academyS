<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Default route
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['reset-password'] = 'auth/reset_password';

// Course routes
$route['courses'] = 'home/catalog';
$route['submit_quiz'] = 'courses/submit_quiz';
$route['courses/submit_quiz'] = 'courses/submit_quiz';
$route['courses/(:any)/lesson/(:num)'] = 'courses/lesson/$1/$2';
$route['courses/(:any)/quiz/(:num)'] = 'courses/quiz/$1/$2';
$route['courses/category/(:any)'] = 'courses/category/$1';
$route['courses/(:any)'] = 'courses/view/$1';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';
$route['profile'] = 'dashboard/profile';
$route['profile/update'] = 'dashboard/update_profile';
$route['enroll/(:num)'] = 'dashboard/enroll/$1';

// Admin routes
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/users'] = 'admin/users';
$route['admin/add_user'] = 'admin/add_user';
$route['admin/edit_user/(:num)'] = 'admin/edit_user/$1';
$route['admin/delete_user/(:num)'] = 'admin/delete_user/$1';
$route['admin/courses'] = 'admin/courses';
$route['admin/courses/add'] = 'admin/add_course';
$route['admin/courses/edit/(:num)'] = 'admin/edit_course/$1';
$route['admin/courses/delete/(:num)'] = 'admin/delete_course/$1';
$route['admin/lessons'] = 'admin/lessons';
$route['admin/lessons/add'] = 'admin/add_lesson';
$route['admin/lessons/edit/(:num)'] = 'admin/edit_lesson/$1';
$route['admin/lessons/delete/(:num)'] = 'admin/delete_lesson/$1';
$route['admin/categories'] = 'admin/categories';
$route['admin/categories/add'] = 'admin/add_category';
$route['admin/categories/edit/(:num)'] = 'admin/edit_category/$1';
$route['admin/categories/delete/(:num)'] = 'admin/delete_category/$1';

// Coding Exercise Routes
$route['admin/coding_exercises'] = 'admin/coding_exercises';
$route['admin/add_coding_exercise'] = 'admin/add_coding_exercise';
$route['admin/edit_coding_exercise/(:num)'] = 'admin/edit_coding_exercise/$1';
$route['admin/delete_coding_exercise/(:num)'] = 'admin/delete_coding_exercise/$1';
$route['coding/exercise/(:num)'] = 'coding/exercise/$1';
$route['coding/execute'] = 'coding/execute';
$route['coding/submit'] = 'coding/submit';
