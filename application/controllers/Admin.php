<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Admin extends CI_Controller {

	public function __construct(){
           parent::__construct();
		   $this->load->model('Admin_model');
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
		$data['body'] = 'Admincore';

		$data['adminid'] = (isset($_POST['adminid'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['adminid'])) : -1;
		$data['adminkey'] = (isset($_POST['adminkey'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['adminkey'])) : -1;

		if($data['adminid'] != -1 && $data['adminkey'] != -1 && $this->Admin_model->Validate_key($data['adminid'], $data['adminkey'])){
			$_SESSION['admin_connected'] = 1;
			$_SESSION['admin_id'] = $data['adminid'];
			redirect(base_url('index.php/adminpanel'));
		}else{
			redirect(base_url('index.php/admin'));
		}

	}

	public function panel()
	{
		$data = [];
		$data['title'] = 'Session Hub || Admin Panel';
		$data['body'] = 'Admincore';

		if(isset($_SESSION['admin_connected']) && $_SESSION['admin_connected'] && isset($_SESSION['admin_id'])){

			$data['admin'] = $this->Admin_model->Get_admin_data($_SESSION['admin_id']);
			$data['tickets'] = ($data['admin']->ticket_permissions) ? $this->Admin_model->Load_tickets() : 0;
			$this->load->view('templates/main', $data);

		}else{
			redirect(base_url('index.php/logout'));
		}

	}


}

?>
