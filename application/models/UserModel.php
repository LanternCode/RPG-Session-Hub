<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userModel extends CI_Model
{

	function __construct()
    {
		parent::__construct();
    }

    function getUserData( $email )
	{
		$sql = "SELECT id, tag, username, password FROM users WHERE email = '$email'";
		$query = $this->db->query( $sql );

		if( isset( $query->row()->password ) && $query->row()->password )
			return (object) $query->row();
		else return 0;
	}

	function getUserSessions( $userId )
	{
		$sql = "SELECT
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

	function registerNewUser( $username, $userTag, $email, $password )
	{
		$sql = "INSERT INTO users
		( username, tag, email, password )
		VALUES
		( '$username', '$userTag', '$email', '$password')";

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

	//SOURCE: STACK OVERFLOW
	function getToken()
	{
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet .= "0123456789";
		$codeALength = strlen($codeAlphabet) -1;

	    for( $i = 0 ; $i < 255 ; ++$i )
		{
	        $token .= $codeAlphabet[ rand( 0, $codeALength ) ];
	    }

	    return $token;
	}

	function insertPasswordUpdateLink( $email )
	{
		$keyToInsert = $this->getToken();
		$sql = "UPDATE users SET passwordResetKey = '$keyToInsert' WHERE email = '$email'";
		$this->db->simple_query($sql);

		return $keyToInsert;
	}

	function sendPasswordChangeEmail( $email, $resetKey )
	{

		$resetLink = base_url( 'forgottenPassword/reset?qs=' . $resetKey );
		$subject = "Reset Password : RPG Session-Hub";
		$headers = array(
        	'From: No reply',
        	'Reply-To: noreply@RPGSessionHub.pl',
			'MIME-Version: 1.0',
			'Content-Type: text/html; charset=ISO-8859-1'
        );
		$txt = "It appears that someone has requested to change the password assigned to this
				email <br /> on the RPG Session-Hub web application. If it was you, press the
				URL located below.<br /><br />Reset Password: <a href='$resetLink' target='_blank'>
				$resetLink</a><br /><br /> If you did not ask for a password reset, simply ignore this email.";

		mail( $email, $subject, $txt, implode( "\r\n", $headers ) );

	}

	function validatePasswordResetString( $key )
	{
		$sql = "SELECT id FROM users WHERE passwordResetKey = '$key'";
		$query = $this->db->query( $sql );

		if( isset( $query->row()->id ) && $query->row()->id ) return $query->row()->id;
		else return 0;
	}

	function updateUserPassword( $password, $userId )
	{
		$newPass = password_hash( $password, PASSWORD_BCRYPT );
		$sql = "UPDATE users SET passwordResetKey = NULL, password = '$newPass' WHERE id = $userId";
		$this->db->simple_query($sql);
	}

	function generateUserTag( $username )
	{
		$userTagNo = 1;

		$sql = "SELECT tag FROM users WHERE username = '$username' ORDER BY tag DESC LIMIT 1";
		$query = $this->db->query( $sql );
		if( isset( $query->row()->tag ) )
		{
			$userTagNo = $query->row()->tag + 1;
		}

		$userTag = $this->fillUserTag( $userTagNo );

		return $userTag;
	}

	function fillUserTag( $userTagNo )
	{
		$filledUserTag = "";
		switch( strlen( $userTagNo ) )
		{
			case 1:
			{
				$filledUserTag .= "000";
				$filledUserTag .= $userTagNo;
				break;
			}
			case 2:
			{
				$filledUserTag .= "00";
				$filledUserTag .= $userTagNo;
				break;
			}
			case 3:
			{
				$filledUserTag .= "0";
				$filledUserTag .= $userTagNo;
				break;
			}
			case 4:
			{
				$filledUserTag .= $userTagNo;
				break;
			}
		}
		return $filledUserTag;
	}

}
