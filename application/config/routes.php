<?php defined('BASEPATH') OR exit('No direct script access allowed');

//Related to session-creation
$route['createSession']           = 'Home/newsession';
$route['createSession/stepTwo']   = 'Creator/create_one';
$route['createSession/stepThree'] = 'Creator/create_two';
$route['createSession/stepFour']  = 'Creator/summary';

//Inside of a Session - core functionality
$route['key']       = 'Keycheck';
$route['roll']      = "Roll";
$route['sesyjka']   = 'Session';
$route['logout']    = 'Session/close';
$route['listrolls'] = 'Roll/getrolls';

//Inside of a session - GM's settings
$route['session/edit/newuser']    = 'Editor/newUser';
$route['session/edit/modules']    = 'Editor/modules';
$route['session/edit/removeuser'] = 'Editor/removeusers';
$route['session/edit/dices']      = 'Editor/dices';
$route['session/edit/name']       = 'Editor/name';
$route['session/changewiev']      = "Editor/swap";
$route['session/adminwiev']       = "Editor/swap_admin";
$route['session/edit/addquote']   = "Editor/quote";
$route['session/sendticket']      = "Editor/newticket";

//SessionHub Admin panel
$route['adminLogin']          = 'Admin';
$route['adminValidate']       = 'Admin/keycheck';
$route['adminPanel']          = 'Admin/panel';

//Code Igniter default routes
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
