<?php defined('BASEPATH') OR exit('No direct script access allowed');

// User related routes
$route['newAccount']                 = 'Home/newUser';
$route['validateRegistration']       = 'Authentication/register';
$route['userSpace']                  = 'Authentication';
$route['userSpace/acceptInvitation'] = 'Authentication/accept';
$route['userSpace/rejectInvitation'] = 'Authentication/reject';
$route['forgottenPassword']          = 'Home/forgottenPassword';
$route['forgottenPassword/reset']    = 'Home/resetPassword';

//Related to session-creation
$route['createSession']           = 'Home/newsession';
$route['createSession/stepTwo']   = 'Creator/create_one';
$route['createSession/stepThree'] = 'Creator/create_two';

//Inside of a Session - core functionality
$route['userSpace/session']           = 'Session';
$route['userSpace/session/roll']      = 'Roll';
$route['userSpace/session/listrolls'] = 'Roll/getrolls';
$route['userSpace/session/quit']      = 'Session/close';

//Inside of a session - GM's settings
$route['userSpace/session/edit/newUser']    = 'Editor/newUser';
$route['userSpace/session/edit/modules']    = 'Editor/modules';
$route['userSpace/session/edit/removeuser'] = 'Editor/removeusers';
$route['userSpace/session/edit/dices']      = 'Editor/dices';
$route['userSpace/session/edit/name']       = 'Editor/name';
$route['userSpace/session/userView']        = "Editor/userView";
$route['userSpace/session/adminView']       = "Editor/adminView";
$route['userSpace/session/edit/addquote']   = "Editor/quote";

//SessionHub Admin panel
$route['adminLogin']          = 'Admin';
$route['adminValidate']       = 'Admin/keycheck';
$route['adminPanel']          = 'Admin/panel';

//Special routes
$route['TOS']                    = 'Home/termsOfService';
$route['sessionExpired']         = 'Home/sessionExpired';
$route['logout']                 = 'Home/logout';

//Contact-related routes
$route['contact']                = 'Home/contact';
$route['contact/sendTicket']     = 'Home/submitTicket';

//Code Igniter default routes
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
