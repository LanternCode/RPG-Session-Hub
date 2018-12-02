<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userModel extends CI_Model{

	function __construct()
    {
		parent::__construct();
    }

    function getUserData( $email )
	{
		$sql = "SELECT id, username, password FROM users WHERE email = '$email'";
		$query = $this->db->query( $sql );

		if( isset( $query->row()->password ) && $query->row()->password )
			return (object) $query->row();
		else return 0;
	}

	function getUserSessions( $userId )
	{
		$sql = "SELECT DISTINCT
		s.id, s.name, s.participants,
		p.session_id
		FROM participants AS p
		JOIN sessions AS s
		ON p.session_id = s.id
		WHERE p.userId = $userId";

		$query = $this->db->query( $sql );

		if( $query->result() )
			return $query->result();
		else return array();

	}

	function registerNewUser( $username, $email, $password )
	{
		$sql = "INSERT INTO users
		( username, email, password )
		VALUES
		( '$username', '$email', '$password')";

		$this->db->simple_query( $sql );
	}

	function isEmailUnique( $email )
	{
		$sql = "SELECT email FROM users WHERE email = '$email'";
		$query = $this->db->query( $sql );

		if( isset( $query->row()->email ) && $query->row()->email ) return 0;
		else return 1;
	}

	function getUserSessionsGamemasters( $sessions = [] )
	{

		$gamemasters = array();

		if( isset( $sessions ) && count( $sessions ) > 0 )
		{
			foreach($sessions as $session)
			{
				$sql = "SELECT name FROM participants WHERE rank = 1 AND session_id = $session->session_id";

				$query = $this->db->query($sql);
				if( isset( $query->row()->name ) && $query->row()->name )
					array_push( $gamemasters, $query->row()->name );
			}
		}


		return $gamemasters;
	}

	function isUserGamemaster( $userId, $sessionId )
	{
		$sql = "SELECT rank FROM participants WHERE userId = $userId AND session_id = $sessionId";
		$query = $this->db->query( $sql );

		if( $query->row()->rank == 1 ) return 1;
		else return 0;
	}

	function addInvite( $invitedEmail, $invitedSessionId )
	{
		$sql = "INSERT INTO invites( email, sessionId )VALUES( '$invitedEmail', $invitedSessionId )";
		$query = $this->db->query( $sql );
	}

	function sendEmailInvitation( $email, $sessionName, $GMName )
	{
		return;
	}

	function getUserInvitations( $userEmail )
	{
		$sql = "SELECT
		i.sessionId,
		s.name, s.participants,
		p.name AS gmName
		FROM invites AS i
		JOIN sessions AS s
		ON i.sessionId = s.id
		JOIN participants AS p
		ON p.session_id = s.id
		WHERE i.email = '$userEmail'
		AND p.rank = 1
		AND i.status = 0
		";

		$query = $this->db->query( $sql );
		return $query->result();

	}

	function getUserEmailById( $userId )
	{
		$sql = "SELECT email FROM users WHERE id = $userId";
		$query = $this->db->query( $sql );
		return $query->row()->email;
	}

	function getUserHangingInvitationId( $email, $sessionId )
	{
		$sql = "SELECT id FROM invites WHERE email='$email' AND sessionId = $sessionId AND status = 0";
		return $this->db->query( $sql )->row()->id;
	}

	function changeInvitationStatus( $email, $sessionId, $status )
	{
		$invitationId = $this->getUserHangingInvitationId( $email, $sessionId );

		$sql = "UPDATE invites SET status = $status WHERE id = $invitationId";
		$this->db->simple_query( $sql );
	}

	function Send_ticket( $title, $message, $senderEmail )
	{
		$sql = "INSERT INTO tickets (senderEmail, title, message)VALUES('$senderEmail', '$title', '$message')";
		$this->db->simple_query( $sql );
	}

}
