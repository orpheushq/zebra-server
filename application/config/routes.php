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
$route['default_controller'] = 'pages';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['api/auth/(:any)'] = 'auth/$1';
//$route['api/(:any)'] = function ($command)
//{
//	/*
//		* This code checks if the command exists (if the function exists) in the Api controller otherwise shows an error
//	*/
//    require_once FCPATH."system/core/Controller.php";
//    require_once APPPATH.'controllers/Api.php';
//    $rc = new ReflectionClass('Api');
//
//    if ($rc->hasMethod($command)) {
//    	return "api/".$command;
//    } else {
//    	return "api/error";
//    }
//};
//$route['api/otp/(:any)'] = 'passcode/$1';

/**
 * The route below handles all routes in the form of api/{x}/{y} or api/{x}/{y}/{z} (automatically scales to all levels)
 * The route is handled by {x}api/command/x/y
 *  ex: api/supplier/test is directed to supplierApi/test
 *  ex: api/classification/test/1/2 is directed to classificationApi/test/1/2
 * There can be as many number of sub levels, the route will automatically arrange to accept all routes
 * It turns out that on localhost, both supplierapi and supplierApi can be referenced by 'supplierapi'
 *  But on production server, route should resolve to 'supplierApi', NOT 'supplierapi'
 */
$route['api/(:any)/(.+)'] = '$1Api/$2';

/**
 * This route handles the index level calls of the above route
 *  Ex: api/supplier is directed to supplierapi/index
 */
$route['api/(:any)'] = '$1Api';
//$route['api/machine'] = 'MachineApi';


$route['logout'] = 'pages/logout';

$route['upload'] = 'pages/upload';

$route['attendance'] = 'pages/attendance';
$route['attendance/(:num)'] = 'pages/attendance/$1';
$route['attendance/view/(:num)'] = 'pages/attendance_view/$1';
$route['attendance/new'] = 'pages/attendance_view/-1';