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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['test'] = 'test';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//user Routes
$route['user']='UserController';
$route['user/add']='UserController/add';
$route['user/store']='UserController/store';
$route['user/edit']='UserController/edit';
$route['user/update']='UserController/update';
$route['user/show']='UserController/show';
$route['user/delete']='UserController/delete';
$route['activate']='UserController/activate';
$route['username/unique']='UserController/is_userName_Valid';
$route['email/unique']='UserController/is_email_Valid';

//team Router
$route['team']='TeamController';
$route['team/add']='TeamController/add';
$route['team/store']='TeamController/store';
$route['team/edit']='TeamController/edit';
$route['team/update']='TeamController/update';
$route['team/show']='TeamController/show';
$route['team/delete']='TeamController/delete';
$route['team_name/unique']='TeamController/is_team_name_valid';
//match Router
$route['match']='MatchController';
$route['match/add']='MatchController/add';
$route['match/store']='MatchController/store';
$route['match/edit']='MatchController/edit';
$route['match/update']='MatchController/update';
$route['match/show']='MatchController/show';
$route['match/delete']='MatchController/delete';
//prediction Router
$route['prediction']='PredictionController';
$route['prediction/add']='PredictionController/add';
$route['prediction/store']='PredictionController/store';
$route['prediction/edit']='PredictionController/edit';
$route['prediction/update']='PredictionController/update';
$route['prediction/show']='PredictionController/show';
$route['prediction/delete']='PredictionController/delete';
$route['prediction/once']='PredictionController/is_prediction_valid';
//survey Router
$route['survey']='SurveyController';
$route['survey/add']='SurveyController/add';
$route['survey/store']='SurveyController/store';
$route['survey/edit']='SurveyController/edit';
$route['survey/update']='SurveyController/update';
$route['survey/show']='SurveyController/show';
$route['survey/delete']='SurveyController/delete';

