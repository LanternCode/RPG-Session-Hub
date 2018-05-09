<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Editor extends CI_Controller {

	public function __construct(){
           parent::__construct();
           $this->load->model('Creator_model');
		   $this->load->model('Editor_model');
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
                $this->Editor_model->Change_participant_count($_SESSION['session_id'], 1);
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
		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';

			$data['quote_module_on'] = (isset($_POST['quotemodule'])) ? 1 : 0;
	  		$data['quote_module_allow_everyone'] = (isset($_POST['quotemoduleall'])) ? 1 : 0;

	  		$data['dice_module_on'] = (isset($_POST['dicemodule'])) ? 1 : 0;
	  		$data['dice_module_allow_everyone'] = (isset($_POST['dicemoduleall'])) ? 1 : 0;

			if($data['quote_module_on'] == 1 && isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_quotes($_SESSION['session_id'], 1);
			else if(isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_quotes($_SESSION['session_id'], 0);

			if($data['quote_module_allow_everyone'] == 1 && isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_quotes_addition_for_all($_SESSION['session_id'], 1);
			else if(isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_quotes_addition_for_all($_SESSION['session_id'], 0);

			if($data['dice_module_on'] == 1 && isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_godDice($_SESSION['session_id'], 1);
			else if(isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_godDice($_SESSION['session_id'], 0);

			if($data['dice_module_allow_everyone'] == 1 && isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_godDice_for_all($_SESSION['session_id'], 1);
			else if(isset($_SESSION['session_id'])) $this->Editor_model->Enable_or_disable_godDice_for_all($_SESSION['session_id'], 0);

			redirect(base_url('sesyjka'));

		}else{
			redirect(base_url('logout'));
		}
	}

    public function removeusers()
	{

		if(isset($_SESSION['connected'])){
			$data = [];
			$data['title'] = 'Session Hub';

			$data['user_id'] = (isset($_GET['id'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_GET['id'])) : -1;

			if(isset($_SESSION['session_id']) && $data['user_id'] != -1 && strlen($data['user_id']) > 0){
				$this->Editor_model->Remove_user($data['user_id'], $_SESSION['session_id']);
				$this->Editor_model->Change_participant_count($_SESSION['session_id'], 0);
				redirect(base_url('sesyjka'));
			}else{
				//adminowy error
			}

		}else{
			redirect(base_url('logout'));
		}

	}

    public function dices()
	{

		if(isset($_SESSION['connected']) && isset($_SESSION['session_id'])){
			$data = [];
			$data['title'] = 'Session Hub';

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

			$this->Creator_model->Assign_dices($_SESSION['session_id'], $data['dices']);
			redirect(base_url('sesyjka'));

		}else{
			redirect(base_url('logout'));
		}

	}

    public function name()
	{

		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';

			$data['p_id'] = (isset($_POST['p_id'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['p_id'])) : -1;
			$data['name'] = (isset($_POST['new_name'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['new_name'])) : -1;
            $data['avatar'] = (isset($_POST['new_avatar'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['new_avatar'])) : -1;

			if($data['p_id'] > 0 && isset($_SESSION['session_id'])){

				$this->Editor_model->Update_user_data($_SESSION['session_id'], $data['p_id'], $data['name'], $data['avatar']);
				redirect(base_url('sesyjka'));
			}else{
				//adminowy error
				print_r($data);
			}

		}else{
			redirect(base_url('logout'));
		}

	}

	public function swap()
	{

		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';

			$_SESSION['admin'] = 0;
			redirect(base_url('sesyjka'));

		}else{
			redirect(base_url('logout'));
		}

	}

	public function swap_admin()
	{

		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';

			$_SESSION['admin'] = 1;
			redirect(base_url('sesyjka'));

		}else{
			redirect(base_url('logout'));
		}

	}

	public function quote()
	{

		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';

			$quote = $data['p_id'] = (isset($_POST['add_quote'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['add_quote'])) : -1;
			if(strlen($quote) > 1 && ($quote != -1) && isset($_SESSION['session_id'])) $this->Editor_model->Add_quote($quote, $_SESSION['session_id']);
			redirect(base_url('sesyjka'));

		}else{
			redirect(base_url('logout'));
		}

	}

	public function newticket()
	{

		if(isset($_SESSION['connected'])){

			$data = [];
			$data['title'] = 'Session Hub';
			$data['body'] = 'sesyjka_hub';

			$data['title'] = (isset($_POST['ticket_title'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['ticket_title'])) : -1;
			$data['message'] = (isset($_POST['ticket_content'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['ticket_content'])) : -1;

			if(strlen($data['title']) > 0 && strlen($data['message']) > 0 && $data['title'] != -1 && $data['message'] != -1 && isset($_SESSION['session_id'])){

				$this->Editor_model->Send_ticket($data['title'], $data['message'], $_SESSION['session_id']);
				redirect(base_url('sesyjka'));
			}else{
				redirect(base_url('sesyjka'));
			}

			$this->load->view('templates/main', $data);
		}else{
			redirect(base_url('logout'));
		}

	}

}

?>
