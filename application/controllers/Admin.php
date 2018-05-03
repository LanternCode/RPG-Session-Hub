<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Admin extends CI_Controller {

	public function __construct(){
           parent::__construct();
       }

	public function index()
	{

			$data = [];
			$data['title'] = 'Session Hub || Admin Login';
			$data['body'] = 'Admin';
			$this->load->view('templates/main',$data);

	}

	public function keycheck()
	{

		$data = [];
		$data['title'] = 'Session Hub || Admin Login';
		$data['body'] = 'Admin';
		$this->load->view('templates/main',$data);

	}

}

?>
