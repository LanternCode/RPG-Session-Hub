<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset( $_SESSION ) )
	session_start();

class Creator extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('Creator_model');
		$this->load->model('UserModel');
		$this->load->model('SessionModel');
		$this->load->model('SecurityModel');
    }

	public function create_one()
	{

        if( isset( $_SESSION['connectedSessionId'] ) )
		{
			redirect( base_url( 'userSpace/session?s=' . $_SESSION['connectedSessionId'] ) );
		}
		else
		{
			  $data = [];
	          $data['session_name'] = (isset($_POST['session_name'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['session_name'])) : 0;
	          $data['participants'] = (isset($_POST['participant_count'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_count'])) : '';

			  if( $data['session_name'] && strlen($data['session_name']) > 0 &&
			      is_numeric( $data['participants'] ) && $data['participants'] > 1 && $data['participants'] < 25)
			  {
				  $this->Creator_model->createSession( $data );

				  $_SESSION['session_name'] = $data['session_name'];
				  $_SESSION['participants'] = $data['participants'];

		          $data['body'] = 'createSession/CreatePage2';
		          $this->load->view( 'templates/main', $data );
			  }
			  else
			  {
				  $data['error_name'] = ($data['session_name'] == -1) ? 1 : 0;
				  $data['error_name'] = (strlen($data['session_name']) <= 0) ? 1 : 0;
				  $data['error_participant_count_invalid'] = is_numeric( $data['participants'] ) ? 0 : 1;
				  $data['error_participant_count_too_small'] = ( !$data['error_participant_count_invalid'] && $data['participants'] < 2) ? 1 : 0;
				  $data['error_participant_count_too_high'] = ( !$data['error_participant_count_invalid'] && $data['participants'] > 24) ? 1 : 0;

				 $data['body'] = 'createSession/CreatePage1';
				 $this->load->view('templates/main',$data);
			  }

      	}

    }

	public function create_two()
	{

		if( isset( $_SESSION['connectedSessionId'] ) )
		{
			redirect( base_url( 'userSpace/session?s=' . $_SESSION['connectedSessionId'] ) );
		}
		else if( isset( $_SESSION['userId'] )       && $_SESSION['userId'] &&
			     isset( $_SESSION['participants'] ) && $_SESSION['participants'] &&
			     isset( $_SESSION['session_name'] ) && $_SESSION['session_name'] )
		{
			$data = [];

	        $data['playerCount'] = $_SESSION['participants'];

			$gmName   = isset( $_POST['gamemasterName'] ) ? mysqli_real_escape_string( $this->db->conn_id, $_POST['gamemasterName'] ) : 0;
			$gmAvatar = (isset($_POST['gamemasterAvatarURL'])) ? mysqli_real_escape_string($this->db->conn_id,$_POST['gamemasterAvatarURL']) : 0;
			$gmEmail  = $this->UserModel->getUserEmailById( $_SESSION['userId'] );
			$data['realPlayerCount'] = ($gmName && $gmEmail) ? 1 : 0;

	  		for( $i = 0; $i < $data['playerCount']-1 ; ++$i )
			{
		  		$name = isset( $_POST['participant_'.$i.'_ign'] ) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_'.$i.'_ign'])) : NULL;
		  		$avatar = (isset($_POST['participant_'.$i.'_avatar'])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_'.$i.'_avatar'])) : NULL;
				$email = (isset($_POST['participant_'.$i])) ? trim(mysqli_real_escape_string($this->db->conn_id,$_POST['participant_'.$i])) : NULL;

		  		$name = ( strlen( $name ) < 1 ) ? NULL : $name;
		  		$avatar = ( !$name || strlen( $avatar ) < 5 ) ? NULL : $avatar;
				$email = filter_var( $email, FILTER_VALIDATE_EMAIL ) ? $email : NULL;

				if( $name && $email ) $data['realPlayerCount']++;

		  		$data['p_name' . $i] = $name;
		  		$data['p_avatar' . $i] = $avatar;
				$data['p_email' . $i] = $email;
			}

	  		$data['k4']   = isset( $_POST['k4'] ) ? 1 : 0;
	  		$data['k6']   = isset( $_POST['k6'] ) ? 1 : 0;
	  		$data['k8']   = isset( $_POST['k8'] ) ? 1 : 0;
	  		$data['k10']  = isset( $_POST['k10'] ) ? 1 : 0;
	  		$data['k12']  = isset( $_POST['k12'] ) ? 1 : 0;
	  		$data['k20']  = isset( $_POST['k20'] ) ? 1 : 0;
	  		$data['k100'] = isset( $_POST['k100'] ) ? 1 : 0;

	  		if(!$data['k4'] && !$data['k6'] && !$data['k8'] && !$data['k10'] && !$data['k12'] && !$data['k20'] && !$data['k100'])
			{
				//If no dice is set, select K20 by default
	  			$data['k20'] = 1;
	  		}

	  		$data['dices'] = $data['k4'] . "," . $data['k6'] . "," . $data['k8'] . "," .
	  		$data['k10'] . "," . $data['k12'] . "," . $data['k20'] . "," . $data['k100'];

	  		if( filter_var( $gmEmail, FILTER_VALIDATE_EMAIL ) && $data['realPlayerCount'] > 1 && isset( $_SESSION['session_name'] ) &&
	  	  		strlen( $gmName ) > 0)
			{

	  			$data['session_id'] = $this->Creator_model->GetSessionIdBySessionName( $_SESSION['session_name'] );

	  			$this->Creator_model->Assign_dices( $data['session_id'], $data['dices'] );

				$gmEmail = $this->UserModel->getUserEmailById( $_SESSION['userId'] );
	  			for( $i = 0; $i < $data['realPlayerCount']; ++$i )
				{
	  				if( $i == (  $data['realPlayerCount'] - 1 ) )
					{
						$this->SessionModel->addParticipant( $_SESSION['userId'], $data['session_id'] , $gmName, $gmAvatar, 1 );
					}
					else
					{
						if( $this->SecurityModel->userNotInvitedNorParticipates( $data['p_email' . $i], $data['session_id'] )
							&& $gmEmail != $data['p_email' . $i] )
						{
							$this->UserModel->addInvite( $data['p_email' . $i], $data['session_id'] );
							$this->UserModel->sendEmailInvitation( $data['p_email' . $i], $_SESSION['session_name'], $gmName );

							$this->SessionModel->addParticipant( $data['p_email' . $i], $data['session_id'],
							 	"(INVITED) " . $data['p_name' . $i], $data['p_avatar' . $i], 0 );
						}
					}
	  			}

				if( $data['playerCount'] != $data['realPlayerCount'] )
					$this->SessionModel->setParticipantCount( $data['session_id'], $data['realPlayerCount'] );

	  	        $data['body'] = 'createSession/CreatePageEnd';
	  	        $this->load->view( 'templates/main', $data );

	  	  	}
			else
			{

	  			$data['error_mail'] = filter_var( $gmEmail, FILTER_VALIDATE_EMAIL ) ? 0 : 1;
	  			$data['gamemaster_name_error'] = isset( $gmName ) ? ( strlen( $gmName ) > 0 ? 0 : 1) : 1;
	  			$data['p_count_error'] = $data['realPlayerCount'] > 1 ? 0 : 1;

	  			$data['body'] = 'createSession/CreatePage2';
	  			$this->load->view( 'templates/main', $data );

	  		}
		}
		else redirect( base_url( 'sessionExpired' ) );
	}

}

?>
