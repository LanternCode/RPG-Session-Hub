<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Editor_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Remove_user($user_id, $session_id)
		{

            $sql = "DELETE FROM participants WHERE p_id = $user_id AND session_id = $session_id";
            $query = $this->db->query($sql);
        }

        function Change_participant_count($session_id, $state)
		{
            $sign = ($state) ? '+' : '-';

			$sql = "UPDATE sessions SET participants = participants ";
            $sql .= $sign;
            $sql .= " 1 WHERE id = $session_id";

			$query = $this->db->query($sql);
		}

        function Update_user_data($session_id, $participant_id, $new_name, $new_avatar)
		{

			$name_change = (strlen($new_name) == 0 || $new_name == -1) ? 0 : 1;
            $avatar_change = ($new_avatar == '-1' || strlen($new_avatar) == 0) ? 0 : 1;

            $sql = "UPDATE participants SET ";
			if($name_change) $sql .= "name = '$new_name'";
            if($avatar_change && !$name_change) $sql .= "avatar = '$new_avatar'";
			else if($avatar_change && $name_change) $sql .= ", avatar = '$new_avatar'";
			else if(!$avatar_change && !$name_change) return 1;
            $sql .= " WHERE session_id = $session_id AND p_id = $participant_id";

            $query = $this->db->query($sql);

        }

		function Enable_or_disable_quotes($session_id, $status)
		{

			$sql = "UPDATE sessions SET quotes = $status WHERE id = $session_id";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_quotes_addition_for_all($session_id, $status)
		{

			$sql = "UPDATE sessions SET quotes_all = $status WHERE id = $session_id";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_godDice($session_id, $status)
		{

			$sql = "UPDATE sessions SET goddice = $status WHERE id = $session_id";
			$query = $this->db->query($sql);

		}

		function Enable_or_disable_godDice_for_all($session_id, $status)
		{

			$sql = "UPDATE sessions SET goddice_all = $status WHERE id = $session_id";
			$query = $this->db->query($sql);

		}

		function Add_quote($quote, $session_id)
		{

			$sql = "INSERT INTO quotes (session_id, quote)VALUES($session_id, '$quote')";
			$query = $this->db->query($sql);

		}

		function Send_ticket($title, $message, $session_id)
		{

			$sql = "INSERT INTO tickets (session_id, title, message)VALUES($session_id, '$title', '$message')";
			$query = $this->db->query($sql);

		}

}
