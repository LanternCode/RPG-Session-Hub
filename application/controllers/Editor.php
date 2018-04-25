<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Editor extends CI_Controller {

	public function __construct(){
           parent::__construct();
           $this->load->model('Creator_model');
       }

	public function newUser()
	{

		if(isset($_SESSION['connected'])){
			$data = [];
			$data['title'] = 'Session Hub';

            $data['name'] = (isset($_POST['add_user_name'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['add_user_name'])) : -1;
            $data['avatar'] = (isset($_POST['add_user_avatar'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['add_user_avatar'])) : -1;

            If(strlen($data['name']) > 0 && $data['name'] != -1 && isset($_SESSION['session_id'])){
                $this->Creator_model->Add_participants($_SESSION['session_id'], $data['name'], $data['avatar'], 0);
                $this->Creator_model->Increase_participant_count($_SESSION['session_id']);
                redirect(base_url('sesyjka'));
            }else{
                //adminowy error
            }

		}else{
			redirect(base_url('logout'));
		}

	}

	public function modules()
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

    public function users()
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

    public function dices()
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

    public function name()
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

}

?>
