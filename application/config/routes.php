<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['key'] = 'Keycheck';
$route['roll'] = "Roll";
$route['sesyjka'] = 'Session';
$route['logout'] = 'Session/close';
$route['listrolls'] = 'Roll/getrolls';

$route['session/edit/newuser'] = 'Editor/name';
$route['session/edit/modules'] = 'Editor/modules';
$route['session/edit/removeuser'] = 'Editor/users';
$route['session/edit/dices'] = 'Editor/dices';

//Related to session-creation
$route['new'] = 'Home/newsession';
$route['SessionCreator'] = 'Creator/create_one';
$route['SessionCreator2'] = 'Creator/create_two';
$route['Summary'] = 'Creator/summary';

$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

?>