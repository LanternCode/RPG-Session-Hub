<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$debugging = 1;
$hostname = $debugging ? 'localhost' : 'sql.infinity123.nazwa.pl';
$username = $debugging ? 'root' : 'infinity123_sessions';
$password = $debugging ? '' : 'Rq9:gM3nABJE_%C)iz*y4fpD';
$database = $debugging ? 'sessions' : 'infinity123_sessions';

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $hostname,
	'username' => $username,
	'password' => $password,
	'database' => $database,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
