<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_SESSION)) session_start();

class Admin extends CI_Controller
{

	public function __construct()
	{
    	parent::__construct();
		$this->load->model( 'Admin_model' );
    }

	public function index()
	{

		if( isset( $_SESSION['admin_id'] ) && $_SESSION['admin_id'] )
		{
			redirect( base_url( 'adminPanel' ) );
		}
		else if( isset( $_SESSION['connectedSessionId'] ) && $_SESSION['connectedSessionId'])
		{
			redirect( base_url( 'sesyjka' ) );
		}

		$data = array(
			'title' => 'Session Hub || Admin Login',
			'body' => 'admin/adminLogin'
		);
		$this->load->view( 'templates/main', $data );

	}

	public function keycheck()
	{

		$config = array(
			array(
				'field'		=> 'admin--login',
				'label'		=> "Login",
				'rules'		=> 'htmlspecialchars|trim|required|alpha_numeric'
			),
			array(
				'field'		=> 'admin--password',
				'label'		=> "Password",
				'rules'		=> 'htmlspecialchars|trim|required|alpha_numeric|min_length[8]'
			)
		);

		$this->form_validation->set_rules( $config );

		if( $this->form_validation->run() == FALSE )
		{
			$data = array(
				'title' => 'Session Hub || Admin',
				'body' => 'admin/adminLogin',
				'incorrectCredentialsError' => TRUE
			);
			$this->load->view( 'templates/main', $data );
		}
		else
		{
			if( $this->Admin_model->Validate_key( $_POST['admin--login'], $_POST['admin--password'] ) )
			{
				//$_SESSION['admin_connected'] = 1;
				$_SESSION['admin_id'] = $_POST['admin--login'];
				redirect( base_url( 'adminPanel' ) );
			}
		}

	}

	public function panel()
	{
		$data = [];
		$data['title'] = 'Session Hub || Admin Panel';
		$data['body'] = 'admin/adminCore';

		if(/*isset($_SESSION['admin_connected']) && $_SESSION['admin_connected'] && */isset( $_SESSION['admin_id'] ) )
		{
			$data['admin'] = $this->Admin_model->Get_admin_data( $_SESSION['admin_id'] );
			$data['tickets'] = ( $data['admin']->ticket_permissions ) ? $this->Admin_model->Load_tickets() : 0;
			$this->load->view( 'templates/main', $data );
		}
		else redirect( base_url( 'logout' ) );


	}


}

?>
