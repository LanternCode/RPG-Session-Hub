<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset( $_SESSION ) )
	session_start();

class Authentication extends CI_Controller
{

	public function __construct()
	{
    	parent::__construct();
		$this->load->model( 'userModel' );
		$this->load->model( 'securityModel' );
		$this->load->model( 'sessionModel' );
    }

    public function index()
    {

		if( isset( $_SESSION['userLoggedIn'] ) && $_SESSION['userLoggedIn'] && isset( $_SESSION['userId'] ) && $_SESSION['userId'] )
		{

			if( isset( $_SESSION['connectedSessionId'] ) )
			{
				redirect( base_url( 'userSpace/session?s=' . $_SESSION['connectedSessionId'] ) );
			}
			else
			{
				$data['userSessions'] = $this->userModel->getUserSessions( $_SESSION['userId'] );
				$myEmail = $this->userModel->getUserEmailById( $_SESSION['userId'] );
				$data['myInvitations'] = $this->userModel->getUserInvitations( $myEmail );
				$data['gamemasters'] = $this->userModel->getUserSessionsGamemasters( $data['userSessions'] );
				$data['body'] = 'user/userspace';
				$this->load->view( 'templates/main', $data );
			}

		}
		else
		{

	        $data = array(
			    'body' => 'Homepage',
				'invalidCredentials' => 0
			);

	        $data['email'] = ( isset( $_POST['account--signin--email'] ) ) ?
			    trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['account--signin--email'] ) ) : NULL;

		 	$data['password'] = ( isset( $_POST['account--signin--password'] ) ) ?
			    trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['account--signin--password'] ) ) : NULL;

			if( isset( $data['email'] ) && $data['email'] && filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) )
			{
				$userData = $this->userModel->getUserData( $data['email'] );
				$passwordToCompare = isset( $userData->password ) ? $userData->password : 0;

				if( $passwordToCompare && password_verify( $data['password'], $passwordToCompare ) )
				{
					$_SESSION['userLoggedIn'] = 1;
					$_SESSION['userId'] = $userData->id;
					$_SESSION['username'] = $userData->username;

					$data['userSessions'] = $this->userModel->getUserSessions( $userData->id );
					$data['myInvitations'] = $this->userModel->getUserInvitations( $data['email'] );
					$data['gamemasters'] = $this->userModel->getUserSessionsGamemasters( $data['userSessions'] );

					$data['body'] = 'user/userspace';
				}
				else $data['invalidCredentials'] = 1;
			}
			else $data['invalidCredentials'] = 1;

			$this->load->view( 'templates/main', $data );
	  }

    }

	public function register()
	{

		$data = array(
			'body' => 'Homepage'
		);

		$username		= isset( $_POST['register--username'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['register--username'] ) ) : 0;
		$email			= isset( $_POST['register--email'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['register--email'] ) ) : 0;
		$password		= isset( $_POST['register--password'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['register--password'] ) ) : 0;
		$passwordRep 	= isset( $_POST['register--password__repetition'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['register--password__repetition'] ) ) : 0;
		$termsOfService	= isset( $_POST['register--TOS'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['register--TOS'] ) ) : 0;

		$data['usernameTooShort'] = $username ? 0 : "Enter an username!";
		$data['usernameTooLong']  = strlen( $username ) > 20 ? "Username can't be longer than 20 characters." : 0;

		$data['emailFormatInvalid'] = filter_var( $email, FILTER_VALIDATE_EMAIL ) ? 0 : "Enter your email!";
		$data['emailTooLong'] 		= strlen( $email ) > 50 ? "Email can't be longer than 50 characters." : 0;
		$data['emailRepeated'] 		= $this->userModel->isEmailUnique( $email ) ? 0 : "An account with this email already exists.";
		//TODO: forgotten password?

		$data['passwordTooShort'] = strlen( $password ) > 3 ? 0 : "Password must be at least 4-characters long!";
		$data['passwordTooLong']  = strlen( $password ) > 25 ? "Password can't be longer than 25 characters." : 0;

		$data['passwordRepetitionNotMatching'] = $password == $passwordRep ? 0 : "Entered passwords aren't the same!";

		$data['termsOfServiceDenied'] = !$termsOfService ? "In order to continue you have to agree with our TOS." : 0;


		if( $data['usernameTooShort'] || $data['usernameTooLong'] ||
			$data['emailFormatInvalid'] || $data['emailTooLong'] || $data['emailRepeated'] ||
			$data['passwordTooShort'] || $data['passwordTooLong'] ||
			$data['passwordRepetitionNotMatching'] ||
			$data['termsOfServiceDenied'] )
		{

			$dataKeys = array_keys( $data );
			for( $i = 0; $i < count( $dataKeys ); ++$i )
			{
				if( !$data[ $dataKeys[ $i ] ] ) $data[ $dataKeys[ $i ] ] = "";
				else
				{
					$addInFront = "<h4 class='registration--error'>";
					$addInFront .= $data[ $dataKeys[ $i ] ];
					$addInFront .= "</h4>";
					$data[ $dataKeys[ $i ] ] = $addInFront;
				}
			}

			$data['setUsername']      	   = ( $data['usernameTooShort'] || $data['usernameTooLong'] ) ? "" : $username;
			$data['setEmail']			   = ( $data['emailFormatInvalid'] || $data['emailTooLong'] || $data['emailRepeated'] ) ? "" : $email;
			$data['setPassword']	  	   = ( $data['passwordTooShort'] || $data['passwordTooLong'] ) ? "" : $password;
			$data['setPasswordRepetition'] = ( $data['setPassword'] && !$data['passwordRepetitionNotMatching'] ) ? $password : "";
			$data['setTOS']                = $data['termsOfServiceDenied'] ? "" : "checked";

			$data['body'] = 'user/register';
		}
		else
		{
			$password = password_hash( $password, PASSWORD_BCRYPT );
			$data['userHasRegistered'] = 1;
			$this->userModel->registerNewUser( $username, $email, $password );
		}

		$this->load->view( 'templates/main', $data );

	}

	public function accept()
	{

		$sessionId = ( isset( $_GET['i'] ) ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_GET['i'] ) ) : 0;

		if( isset( $_SESSION['userId'] ) && $_SESSION['userId'] )
		{

			$userEmail = $this->userModel->getUserEmailById( $_SESSION['userId'] );
			if( $sessionId && $this->securityModel->userWasInvitedToSession( $userEmail, $sessionId ) )
			{
				$this->userModel->changeInvitationStatus( $userEmail, $sessionId, 1 );
				$this->sessionModel->acceptParticipant( $userEmail, $sessionId, $_SESSION['userId'] );
			}

			redirect( base_url( 'userSpace' ) );
		}
		else redirect( base_url( 'sessionExpired' ) );

	}

	public function reject()
	{

		$sessionId = ( isset( $_GET['i'] ) ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_GET['i'] ) ) : 0;

		if( isset( $_SESSION['userId'] ) && $_SESSION['userId'] )
		{

			$userEmail = $this->userModel->getUserEmailById( $_SESSION['userId'] );
			if( $sessionId && $this->securityModel->userWasInvitedToSession( $userEmail, $sessionId ) )
			{
				$this->userModel->changeInvitationStatus( $userEmail, $sessionId, 2 );
				$this->sessionModel->removeParticipant( $userEmail, $sessionId );
				$this->sessionModel->updateParticipantCount( $sessionId, 0 );
			}

			redirect( base_url( 'userSpace' ) );
		}
		else redirect( base_url( 'sessionExpired' ) );

	}

 }
