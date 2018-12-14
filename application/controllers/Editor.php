<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset( $_SESSION ) )
	session_start();

class Editor extends CI_Controller
{

	public function __construct()
	{
        parent::__construct();
        $this->load->model( 'Creator_model' );
		$this->load->model( 'sessionModel' );
		$this->load->model( 'userModel' );
		$this->load->model( 'securityModel' );
    }

	public function newUser()
	{

		if( isset( $_SESSION['connectedSessionId'] ) && $_SESSION['connectedSessionId'] )
		{

            $userEmail       = isset( $_POST['addUserEmail'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['addUserEmail'] ) ) : 0;
			$userDisplayName = isset( $_POST['addUserDisplayName'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['addUserDisplayName'] ) ) : 0;
            $userAvatar      = isset( $_POST['addUserAvatarLink'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['addUserAvatarLink'] ) ) : 0;
			$sessionName     = isset( $_POST['addUserSessionName'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['addUserSessionName'] ) ) : 0;
			$gmName          = isset( $_POST['addUserGamemasterName'] ) ? trim( mysqli_real_escape_string( $this->db->conn_id, $_POST['addUserGamemasterName'] ) ) : 0;
			$sessionId       = $_SESSION['connectedSessionId'];

			if( $sessionName && $gmName && $userDisplayName && filter_var( $userEmail, FILTER_VALIDATE_EMAIL ) )
			{
				if( $this->securityModel->userNotInvitedNorParticipates( $userEmail, $sessionId ) )
				{
					$this->userModel->addInvite( $userEmail, $sessionId );
					$this->userModel->sendEmailInvitation( $userEmail, $sessionName, $gmName );

					$this->sessionModel->updateParticipantCount( $sessionId, 1 );
					$this->sessionModel->addParticipant( $userEmail, $sessionId, "(INVITED) " . $userDisplayName, $userAvatar, 0);
				}
			}

			redirect( base_url( 'userSpace/session?s=' . $sessionId ) );
		}
		else
		{
			redirect( base_url( 'sessionExpired' ) );
		}

	}

	public function modules()
	{
		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) ){

			$data = [];
			$data['title'] = 'Session Hub';

			$data['quote_module_on'] = (isset($_POST['quotemodule'])) ? 1 : 0;
	  		$data['quote_module_allow_everyone'] = (isset($_POST['quotemoduleall'])) ? 1 : 0;

	  		$data['dice_module_on'] = (isset($_POST['dicemodule'])) ? 1 : 0;
	  		$data['dice_module_allow_everyone'] = (isset($_POST['dicemoduleall'])) ? 1 : 0;

			if($data['quote_module_on'] == 1 && isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_quotes($_SESSION['connectedSessionId'], 1);
			else if(isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_quotes($_SESSION['connectedSessionId'], 0);

			if($data['quote_module_allow_everyone'] == 1 && isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_quotes_addition_for_all($_SESSION['connectedSessionId'], 1);
			else if(isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_quotes_addition_for_all($_SESSION['connectedSessionId'], 0);

			if($data['dice_module_on'] == 1 && isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_godDice($_SESSION['connectedSessionId'], 1);
			else if(isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_godDice($_SESSION['connectedSessionId'], 0);

			if($data['dice_module_allow_everyone'] == 1 && isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_godDice_for_all($_SESSION['connectedSessionId'], 1);
			else if(isset($_SESSION['connectedSessionId'])) $this->sessionModel->Enable_or_disable_godDice_for_all($_SESSION['connectedSessionId'], 0);

			redirect( base_url( 'userSpace' ) );

		}
		else redirect( base_url( 'sessionExpired' ) );

	}

    public function removeusers()
	{

		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{
			$data = [];
			$data['title'] = 'Session Hub';

			$data['user_id'] = (isset($_GET['id'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_GET['id'])) : -1;

			if(isset($_SESSION['connectedSessionId']) && $data['user_id'] != -1 && strlen($data['user_id']) > 0){
				$this->sessionModel->Remove_user($data['user_id'], $_SESSION['connectedSessionId']);
				$this->sessionModel->updateParticipantCount($_SESSION['connectedSessionId'], 0);
				redirect( base_url( 'userSpace' ) );
			}else{
				//TODO: wtf
			}

		}
		else redirect( base_url( 'sessionExpired' ) );

	}

    public function dices()
	{

		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{
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

			$this->Creator_model->Assign_dices($_SESSION['connectedSessionId'], $data['dices']);
			redirect( base_url( 'userSpace' ) );

		}
		else redirect( base_url( 'sessionExpired' ) );

	}

    public function name()
	{

		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{

			$data = [];
			$data['title'] = 'Session Hub';

			$data['p_id'] = (isset($_POST['p_id'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['p_id'])) : -1;
			$data['name'] = (isset($_POST['new_name'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['new_name'])) : -1;
            $data['avatar'] = (isset($_POST['new_avatar'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['new_avatar'])) : -1;

			if($data['p_id'] > 0 && isset($_SESSION['connectedSessionId'])){

				$this->sessionModel->Update_user_data($_SESSION['connectedSessionId'], $data['p_id'], $data['name'], $data['avatar']);
				redirect( base_url( 'userSpace' ) );
			}else{
				//TODO: ???
				//print_r($data);
			}

		}
		else redirect( base_url( 'sessionExpired' ) );

	}

	public function userView()
	{
		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{
			$data = [];
			$data['title'] = 'Session Hub';

			$_SESSION['GMViewEnabled'] = 0;
			redirect( base_url( 'userSpace' ) );
		}
		else redirect( base_url( 'sessionExpired' ) );
	}

	public function adminView()
	{
		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{
			$data = [];
			$data['title'] = 'Session Hub';

			$_SESSION['GMViewEnabled'] = 1;
			redirect( base_url( 'userSpace' ) );
		}
		else redirect( base_url( 'sessionExpired' ) );
	}

	public function quote()
	{

		if( isset( $_SESSION['connectedSessionId'] ) && isset( $_SESSION['userId'] ) )
		{

			$data = [];
			$data['title'] = 'Session Hub';

			$quote = $data['p_id'] = (isset($_POST['add_quote'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['add_quote'])) : -1;
			if(strlen($quote) > 1 && ($quote != -1) && isset($_SESSION['connectedSessionId'])) $this->sessionModel->Add_quote($quote, $_SESSION['connectedSessionId']);
			redirect( base_url( 'userSpace' ) );

		}
		else redirect( base_url( 'sessionExpired' ) );

	}

}

?>
