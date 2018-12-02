<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( !isset( $_SESSION ) )
	session_start();

class Session extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model( 'Roll_model' );
		$this->load->model( 'Assignment_model' );
		$this->load->model( 'SecurityModel' );
		$this->load->model( 'UserModel' );
    }

	public function index()
	{

		$data = [];
		$data['sessionId'] = isset( $_GET['s'] ) ? mysqli_real_escape_string( $this->db->conn_id, $_GET['s'] ) : 0;
		$data['sessionId'] = ( isset( $_SESSION['connectedSessionId'] ) && $_SESSION['connectedSessionId'] ) ? $_SESSION['connectedSessionId'] : $data['sessionId'];

		if( !isset( $_SESSION['userId'] ) )
		{
			redirect( base_url( 'sessionExpired' ) );
		}
		else if( $this->securityModel->userHasNoAccessToSession( $_SESSION['userId'], $data['sessionId'] ) )
		{
			redirect( base_url( 'userSpace' ) );
		}
        else
        {
			$_SESSION['connectedSessionId'] = $data['sessionId'];

			$data['GM']            = $this->userModel->isUserGamemaster( $_SESSION['userId'], $data['sessionId'] ) ? 1 : 0;
			$data['GMViewEnabled'] = isset( $_SESSION['GMViewEnabled'] ) ? $_SESSION['GMViewEnabled'] : ( $data['GM'] ? 1 : 0 );
			$data['session']       = $this->Assignment_model->Get_all_session_information( $data['sessionId'] );
			$data['participants']  = $this->Assignment_model->getAllParticipantsInformation( $data['sessionId'] );
			$data['rolls']         = $this->Roll_model->getRollHistory( $data['sessionId'] );
			$data['dices']         = explode( ',', $data['session']->dices );

			$data['myParticipantName'] = "Player X";
			$data['sessionGamemasterName'] = "The GameMaster";
			foreach( $data['participants'] as $participant )
			{
				if( $participant->userId == $_SESSION['userId'] )
					$data['myParticipantName'] = $participant->name;

				if( $participant->rank == 1 )
					$data['sessionGamemasterName'] = $participant->name;
			}



      		$data['body']  = 'sesyjka_hub';
			$data['title'] = $data['session']->name . ' || RPG Session-Hub';

			$this->load->view( 'templates/main', $data );
        }
	}

    public function close()
    {
        $_SESSION['connectedSessionId'] = NULL;
		$_SESSION['who'] = NULL;
		$_SESSION['GMViewEnabled'] = NULL;

        redirect( base_url( 'userSpace' ) );
    }

}
