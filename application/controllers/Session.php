<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Session extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Roll_model');
		$this->load->model('Assignment_model');
       }

	public function index()
	{

		$data = [];
		$data['key'] = (isset($_GET['key'])) ? mysqli_real_escape_string($this->db->conn_id,$_GET['key']) : "";

        if(isset($_SESSION['connected']))
        {

			if(!isset($_SESSION['session_id'])){
				$session_id = $this->Assignment_model->Get_session_id_by_key($data['key']);
				$_SESSION['session_id'] = $session_id;
			}

			$data['admin'] = ($data['key'] == $this->Assignment_model->Get_admin_key($_SESSION['session_id'])) ? 1 : 0;
			if($data['admin']) $_SESSION['admin'] = 1;
			$data['session'] = $this->Assignment_model->Get_all_session_information($_SESSION['session_id']);
			$data['participants'] = $this->Assignment_model->Get_all_participant_information($_SESSION['session_id']);
			$data['rolls'] = $this->Roll_model->Get_Roll_History();
			$data['dices'] = explode(',',$data['session']->dices);

      		$data['body'] = 'sesyjka_hub';
			$data['title'] = $data['session']->name . ' || Session Hub';

            $this->load->view('templates/main',$data);

        }else{
            redirect(base_url());
        }

	}

    public function close()
    {
        session_unset();
        session_destroy();
        redirect(base_url());
    }

}

?>
