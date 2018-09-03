<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Creator extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Creator_model');
       }

	public function create_one()
	{

        if( !isset( $_SESSION['connected'] ) ){

		  $data = [];
          $data['session_name'] = (isset($_POST['session_name'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['session_name'])) : -1;
          $data['participants'] = (isset($_POST['participant_count'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_count'])) : -1;
          $data['type'] = (isset($_POST['session_type'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['session_type']) : 1;

		  if($data['session_name'] != -1 && strlen($data['session_name']) > 0 && $data['participants'] > 1 && $data['participants'] < 25){
			  $this->Creator_model->Create_session($data);
			  $_SESSION['session_name'] = $data['session_name'];
			  $_SESSION['participants'] = $data['participants'];

	          $data['body'] = 'createSession/CreatePage2';
	          $this->load->view('templates/main',$data);
		  }else{
			  $data['error_name'] = ($data['session_name'] == -1) ? 1 : 0;
			  $data['error_name'] = (strlen($data['session_name']) <= 0) ? 1 : 0;
			  $data['error_participant_count_too_small'] = ($data['participants'] < 2) ? 1 : 0;
			  $data['error_participant_count_too_high'] = ($data['participants'] > 24) ? 1 : 0;

			 $data['body'] = 'createSession/CreatePage1';
			 $this->load->view('templates/main',$data);
		  }


      }else{
          redirect(base_url('sesyjka'));
      }

    }

	public function create_two()
	{
		if(!isset($_SESSION['connected']))
		{
		  $data = [];

          $data['pcount'] = (isset($_POST['pcount'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['pcount']) : 0;
		  $data['real_pcount'] = 0;
		  $pcount_iterator = 0;
		  for($i = 0; $i < $data['pcount']; ++$i)
		  {
			  $name = (isset($_POST['participant_'.$i])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_'.$i])) : "";
			  $avatar = (isset($_POST['participant_'.$i.'_avatar'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_'.$i.'_avatar'])) : "0";

			  $name = (strlen($name) < 1) ? "0" : $name;
			  $avatar = ($name == "0" || strlen($avatar) < 5) ? "0" : $avatar;

			  $data['p_name'.$pcount_iterator] = $name;
			  $data['p_avatar'.$pcount_iterator] = $avatar;
			  $data['real_pcount'] = ($name != "0") ? ($data['real_pcount']+1) : $data['real_pcount'];
			  $pcount_iterator = ($name != "0") ? ($pcount_iterator+1) : $pcount_iterator;
		  }

		  $data['mail'] = (isset($_POST['session_host'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['session_host'])) : "";

		  $first_mail_part = strstr($data['mail'], '@', 1);

		  $data['k4'] = (isset($_POST['k4'])) ? 1 : 0;
		  $data['k6'] = (isset($_POST['k6'])) ? 1 : 0;
		  $data['k8'] = (isset($_POST['k8'])) ? 1 : 0;
		  $data['k10'] = (isset($_POST['k10'])) ? 1 : 0;
		  $data['k12'] = (isset($_POST['k12'])) ? 1 : 0;
		  $data['k20'] = (isset($_POST['k20'])) ? 1 : 0;
		  $data['k100'] = (isset($_POST['k100'])) ? 1 : 0;

		  if(!$data['k4'] && !$data['k6'] && !$data['k8'] && !$data['k10'] && !$data['k12'] && !$data['k20'] && !$data['k100']){
			  $data['k20'] = 1;
		  }

		  $data['dices'] = $data['k4'] . "," . $data['k6'] . "," . $data['k8'] . "," .
		  $data['k10'] . "," . $data['k12'] . "," . $data['k20'] . "," . $data['k100'];

		  if(filter_var($data['mail'], FILTER_VALIDATE_EMAIL) && $data['pcount'] > 1 && isset($_SESSION['session_name']) &&
	  	  strlen($data['p_name0']) > 0 && $data['p_name0'] && $data['real_pcount'] > 1){

			  $data['session_id'] = $this->Creator_model->GetSessionIdBySessionName($_SESSION['session_name']);

			  $this->Creator_model->Assign_dices($data['session_id'],$data['dices']);
			  for($i = 0; $i < $data['real_pcount']; ++$i){
				  	$rank = ($i == 0) ? 1 : 0;
				    $this->Creator_model->Add_participants($data['session_id'], $data['p_name'.$i], $data['p_avatar'.$i], $rank);
			  }

			  $session_name_split = explode(' ', $_SESSION['session_name']);
			  $session_first_name_part = $session_name_split[0];
			  $is_name_unique = $this->Creator_model->Is_session_first_name_part_unique($session_first_name_part);
			  if(!$is_name_unique){
				  $session_first_name_part = $this->Creator_model->Assert_unique_session_first_name_part($session_first_name_part);
			  }

			  $session_gm_id = $session_first_name_part . '_' . $first_mail_part;
			  $data['session_user_id'] = $session_first_name_part . '_';

			  $this->Creator_model->Insert_into_identificators($data['session_id'], $session_first_name_part, $session_gm_id);

			  $_SESSION['session_user_id'] = $data['session_user_id'];
			  $_SESSION['session_gm_id'] = $session_gm_id;

	          $data['body'] = 'createSession/CreatePage3';
	          $this->load->view('templates/main',$data);

	  	}else{

			$data['error_mail'] = (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) ? 1 : 0;
			$data['gamemaster_name_error'] = isset($data['p_name0']) ? ((!(strlen($data['p_name0']) > 0)) ? 1 : 0) : 1;
			$data['p_count_error'] = ($data['real_pcount'] > 1) ? 0 : 1;

			$data['body'] = 'createSession/CreatePage2';
			$this->load->view('templates/main',$data);

		}


      }else{
          redirect(base_url('sesyjka'));
      }
	}

	public function summary()
	{

		if(!isset($_SESSION['connected'])){

			 $data['user_id'] = (isset($_POST['user_id'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['user_id'])) : "";

			 if(strlen($data['user_id']) > 0 && !empty($data['user_id'])){

				 $data['gm_id'] = $_SESSION['session_gm_id'];
				 $data['full_user_id'] = $_SESSION['session_user_id'] . $data['user_id'];

				 $this->Creator_model->Add_user_id($data['full_user_id'], $data['gm_id']);

				 session_unset();
				 session_destroy();

				 $data['body'] = 'createSession/CreatePage4';
				 $this->load->view('templates/main',$data);

			 }else{

				 $data['id_error'] = 1;
				 $data['body'] = 'createSession/CreatePage3';
				 $this->load->view('templates/main',$data);
			 }

	 	}else{
		 	redirect(base_url('sesyjka'));
	 	}

	}

}

?>
