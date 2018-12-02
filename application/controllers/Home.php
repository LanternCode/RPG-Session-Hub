<?php defined('BASEPATH') OR exit('No direct script access allowed');
if( !isset( $_SESSION ) ) session_start();

class Home extends CI_Controller
{

	public function __construct()
	{
    	parent::__construct();
		$this->load->model('UserModel');
    }

	public function index()
	{
		if( isset(  $_SESSION['userLoggedIn'] ) )
		{
			redirect( base_url( 'userSpace' ) );
		}
		else
		{
			$data = array(
				'title' => 'RPG Session-Hub',
				'body' => 'Homepage'
			);
			$this->load->view( 'templates/main', $data );
		}
	}

	public function newsession()
	{

		if( isset( $_SESSION['connectedSessionId'] ) )
		{
			redirect( base_url( 'userSpace/session?s=' . $_SESSION['connectedSessionId'] ) );
		}
		else
		{
			$data = array(
				'title' => 'RPG Session-Hub | Create an RPG Session',
				'body' => 'createSession/CreatePage1'
			);
			$this->load->view( 'templates/main', $data );
		}

	}

	public function newUser()
	{

		if( isset( $_SESSION['connectedSessionId'] ) )
		{
			redirect( base_url( 'userSpace/session?s=' . $_SESSION['connectedSessionId'] ) );
		}
		else
		{
			$data = array(
				'title' => 'RPG Session-Hub | Create your account',
				'body' => 'user/register'
			);
			$this->load->view( 'templates/main', $data );
		}

	}

	public function termsOfService()
	{
		$data = array(
			'title' => 'RPG Session-Hub | Terms of Service',
			'body' => 'tos'
		);
		$this->load->view( 'templates/main', $data );
	}

	public function sessionExpired()
	{
		$data = array(
			'title' => 'RPG Session-Hub',
			'body' => 'Homepage',
			'sessionExpired' => 1
		);

		session_unset();
        session_destroy();

		$this->load->view( 'templates/main', $data );
	}

	public function logout()
	{
		session_unset();
        session_destroy();
		redirect( base_url() );
	}

	public function contact()
	{
		$data = array(
			'title'   => 'RPG Session-Hub | Contact Us',
			'body'    => 'contact',
			'email'   => isset( $_SESSION['userId'] ) ? $this->userModel->getUserEmailById( $_SESSION['userId'] ) : 0
		);

		$this->load->view( 'templates/main', $data );
	}

	public function submitTicket()
	{
		$data = array(
			'title'   => 'RPG Session-Hub | Contact Us',
			'body'    => 'contact',
			'email'   => isset( $_SESSION['userId'] ) ? $this->UserModel->getUserEmailById( $_SESSION['userId'] ) :
				( (isset( $_POST['ticket_email'] ) && $_POST['ticket_email']) ? $_POST['ticket_email'] : '' )
		);

		$tTitle = isset( $_POST['ticket_title'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['ticket_title'] ) ) : '';
		$tMessage = isset( $_POST['ticket_content'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['ticket_content'] ) ) : '';

		if( strlen( $tTitle ) > 0 && strlen( $tMessage ) > 0 && strlen( $data['email'] ) > 0 )
		{
			$this->UserModel->Send_ticket( $tTitle, $tMessage, $data['email'] );
			$data['ticketSuccess'] = true;
		}
		else
		{
			$data['ticketSuccess'] = false;
		}

		$this->load->view( 'templates/main', $data );

	}

}
