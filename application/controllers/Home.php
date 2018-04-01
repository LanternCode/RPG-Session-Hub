<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Home extends CI_Controller {

	public function __construct(){
           parent::__construct();
       }

	public function index()
	{

		if(!isset($_SESSION['connected'])){
			$data = [];
			$data['title'] = 'Session Hub';
			$data['body'] = 'Homepage';
			$this->load->view('templates/main',$data);
		}else{
			redirect(base_url('sesyjka'));
		}

	}

	public function newsession()
	{
		if(!isset($_SESSION['connected'])){
			$data = [];
			$data['title'] = 'Session Hub';
			$data['body'] = 'Create';
			$this->load->view('templates/main',$data);
		}else{
			redirect(base_url('sesyjka'));
		}
	}

}

?>
