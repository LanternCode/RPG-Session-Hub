<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class sessionModel extends CI_Model{
		function __construct(){
	     	parent::__construct();
	    }

        function Remove_user( $user_id, $sessionId )
		{
            $sql = "DELETE FROM participants WHERE id = $user_id AND session_id = $sessionId";
            $query = $this->db->query( $sql );
        }

        function updateParticipantCount( $sessionId, $state )
		{
            $sign = ($state) ? '+' : '-';

			$sql = "UPDATE sessions SET participants = participants ";
            $sql .= $sign;
            $sql .= " 1 WHERE id = $sessionId";

			$this->db->simple_query($sql);
		}

        function Update_user_data($sessionId, $participant_id, $new_name, $new_avatar)
		{

			$name_change = ( strlen( $new_name ) == 0 || $new_name == '0') ? 0 : 1;
            $avatar_change = ($new_avatar == '0' || strlen( $new_avatar ) == 0) ? 0 : 1;

            $sql = "UPDATE participants SET ";
			if( $name_change ) $sql .= "name = '$new_name'";
            if( $avatar_change && !$name_change ) $sql .= "avatar = '$new_avatar'";
			else if( $avatar_change && $name_change ) $sql .= ", avatar = '$new_avatar'";
			else if( !$avatar_change && !$name_change ) return 1;
            $sql .= " WHERE session_id = $sessionId AND id = $participant_id";

            $query = $this->db->query($sql);

        }

		function Enable_or_disable_quotes($sessionId, $status)
		{

			$sql = "UPDATE sessions SET quotes = $status WHERE id = $sessionId";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_quotes_addition_for_all($sessionId, $status)
		{

			$sql = "UPDATE sessions SET quotes_all = $status WHERE id = $sessionId";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_godDice($sessionId, $status)
		{

			$sql = "UPDATE sessions SET goddice = $status WHERE id = $sessionId";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_godDice_for_all($sessionId, $status)
		{

			$sql = "UPDATE sessions SET goddice_all = $status WHERE id = $sessionId";
			$query = $this->db->query($sql);

		}

		function Add_quote($quote, $sessionId)
		{

			$sql = "INSERT INTO quotes (session_id, quote)VALUES($sessionId, '$quote')";
			$query = $this->db->query($sql);

		}

		function randomizeDefaultAvatar()
		{
			$sql = "SELECT URL FROM avatars ORDER BY RAND() LIMIT 1";
			$query = $this->db->query($sql);
			return $query->row()->URL;
		}

		function addParticipant( $email, $sessionId, $name, $avatar, $rank )
		{
			if( $email && $sessionId && $name )
			{
				$avatar = filter_var( $avatar, FILTER_SANITIZE_URL );

				if( !filter_var( $avatar, FILTER_VALIDATE_URL ) )
					$avatar = $this->randomizeDefaultAvatar();

				$sql = "INSERT INTO participants (userId, session_id, name, avatar, rank)VALUES( '$email' , $sessionId, '$name', '$avatar', $rank )";
				$this->db->simple_query($sql);
			}
		}

		function acceptParticipant( $email, $sessionId, $userId )
		{
			$sql = "UPDATE participants
			SET userId = $userId,
			name = SUBSTR(name, 11)
			WHERE session_id = $sessionId
			AND userId = '$email'";

			$this->db->simple_query( $sql );
		}

		function removeParticipant( $email, $sessionId )
		{
			$sql = "DELETE
			FROM participants
			WHERE session_id = $sessionId
			AND userId = '$email'";

			$this->db->simple_query( $sql );
		}

		function setParticipantCount( $sessionId, $participantCount )
		{
			$sql = "UPDATE sessions SET participants = $participantCount WHERE id = $sessionId";
			$this->db->simple_query( $sql );
		}

}
