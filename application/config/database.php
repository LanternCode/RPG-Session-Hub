<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$debugging = 0;
$hostname = $debugging ? 'localhost' : 'sql.leanboxptr.nazwa.pl';
$username = $debugging ? 'root' : 'leanboxptr_rpgsessionhubdb';
$password = $debugging ? '' : 'Rq9:gM3nABJE_%C)iz*y4fpD';
$database = $debugging ? 'sessions' : 'leanboxptr_rpgsessionhubdb';

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
