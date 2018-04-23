<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Keycheck extends CI_Controller {

	public function __construct(){
           parent::__construct();
		   $this->load->model('Assignment_model');
       }

       public function index()
       {

		   if(isset($_SESSION['connected'])){

			   redirect(base_url('index.php/sesyjka'));

		   }else{

	           $data = [];
	           $data['key'] = (isset($_POST['code'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['code'])) : "";

	           if(strlen($data['key']) > 0){

	               if($this->Assignment_model->Validate_key($data['key'])){

					   $_SESSION['connected'] = 1;
					   redirect(base_url('sesyjka?key='.$data['key']));

				   }else{
					   redirect(base_url());
				   }

	           }else{
	               redirect(base_url());
	           }

	   		}
       }

   }
