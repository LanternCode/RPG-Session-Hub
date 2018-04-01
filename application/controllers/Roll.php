<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Roll extends CI_Controller {

	public function __construct(){
        parent::__construct();
	    $this->load->model('Roll_model');
       }

       public function index()
       {
           $data = [];
           $_SESSION['who'] = (isset($_SESSION['who'])) ? $_SESSION['who'] : ((isset($_POST['who'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['who']) : 0);

           if($_SESSION['who'])
           {

               $data['comment'] = (isset($_POST['comment'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['comment']) : "";
			   $data['dice'] = (isset($_POST['dice'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['dice']) : "";
			   $data['dice'] = rtrim($data['dice']);
               $data['double'] = (isset($_POST['double'])) ? 1 : 0;
			   $data['first_roll'] = $this->Roll_model->Roll_the_dice($data['dice']);
               $data['sec_roll'] = ($data['double']) ? $this->Roll_model->Roll_the_dice($data['dice']) : 0;
               $data['roll'] = ($data['sec_roll']) ? ($data['first_roll'].' , '.$data['sec_roll']) : $data['first_roll'];

               $this->Roll_model->Update_Roll_History($data);
			   //$this->Roll_model->Increment_rollcount($data['double']);

               redirect(base_url('index.php/sesyjka'));

         }else{
			 redirect(base_url());
		 }
   }

	public function getrolls()
	{

		$data = [];
		$data['body'] = 'rolllist';
		$data['title'] = 'CYBERPUNK ROLLS || Session Hub';
		$data['rolls'] = $this->Roll_model->Get_Roll_History();

		$this->load->view('templates/main',$data);
	}

}
