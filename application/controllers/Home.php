<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset( $_SESSION ) )
	session_start();

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
			'email'   => isset( $_SESSION['userId'] ) ? $this->UserModel->getUserEmailById( $_SESSION['userId'] ) : 0
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

	public function forgottenPassword()
	{
		$data = array(
			'title' => 'RPG Session-Hub',
			'body' => 'user/forgottenPassword',
			'emailEntered' => ( ( isset( $_POST['email'] ) ? trim( $_POST['email'] ) : "") == "" ? 0 : 1),
			'email' => isset( $_POST['email'] ) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ?  trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['email'] ) ) : 0,
			'formSubmitted' => $_POST ? 1 : 0
		);

		if( $data['emailEntered'] )
		{
			if( $data['email'] )
			{

				if( !$this->UserModel->isEmailUnique( $data['email'] ) )
				{
					if( $resetKey = $this->UserModel->insertPasswordUpdateLink( $data['email'] ) )
					{
						$this->UserModel->sendPasswordChangeEmail( $data['email'], $resetKey );
						$data['actionNotification'] = "<span class='universal--successMessage'>Success! Check your inbox to reset your password.</span>";
					}
					else
					{
						$data['actionNotification'] = "Error: Something went wrong. Please try again.";
					}
				}
				else
				{
					$data['actionNotification'] = "Error: There is no account bound to this email.
					<br />If you think this is a mistake, contact us immediately.";
				}
			}
			else
			{
				$data['actionNotification'] = "Error: Please enter a correct email address.";
			}
		}
		else if( $data['formSubmitted'] )
		{
			$data['actionNotification'] = "Error: In order to reset your password, you have to submit your email address first.";
		}

		$this->load->view( 'templates/main', $data );
	}

	public function resetPassword()
	{
		$data = array(
			'title' => 'RPG Session-Hub',
			'body' => 'user/resetPassword',
			'key' => isset( $_GET['qs'] ) ?  trim( mysqli_real_escape_string( $this->db->conn_id, $_GET['qs'] ) ) : 0,
			'formSubmitted' => $_POST ? 1 : 0
		);

		if( isset( $_POST ) && isset( $_SESSION['user'] ) )
		{
			$password = ( isset( $_POST['newPassword'] ) ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['newPassword'] ) ) : NULL;
			$repeatedPassword = ( isset( $_POST['newPasswordRepeated'] ) ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['newPasswordRepeated'] ) ) : NULL;

			if($password && strlen($password) > 3 && $repeatedPassword && $password == $repeatedPassword)
			{
				$this->UserModel->updateUserPassword( $password, $_SESSION['user'] );
				$_SESSION['user'] = "";
				session_unset();
				$data['body'] = 'user/resetPasswordSuccess';
			}
			else if ( $data['formSubmitted'] )
			{
				$data['errorMessage'] = "";

				if( !$password )
					$data['errorMessage'] = "Error: New Password field is required.";
				else if ( strlen( $password ) < 4 )
					$data['errorMessage'] = "Error: Password must be at least 4 characters in length.";
				else if ( !$repeatedPassword )
					$data['errorMessage'] = "Error: Repeat New Password field is required.";
				else if ( $password != $repeatedPassword )
					$data['errorMessage'] = "Error: Entered passwords were different. Please try again.";

				$data['errorMessage'] .= "<br />";
			}
		}
		else if( strlen( $data['key'] ) == 255 && !isset( $_SESSION['user'] ))
		{
			$userId = $this->UserModel->validatePasswordResetString( $data['key'] );
			if($userId) $_SESSION['user'] = $userId;
			else redirect( base_url() );
		}
		else
		{
			redirect( base_url() );
		}

		$this->load->view( 'templates/main', $data );

	}

}
