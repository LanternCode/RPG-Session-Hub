<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Editor_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Remove_user($user_id, $session_id){

            $sql = "DELETE FROM participants WHERE p_id = $user_id AND session_id = $session_id";
            $query = $this->db->query($sql);
        }

        function Change_participant_count($session_id, $state){
            $sign = ($state) ? '+' : '-';

			$sql = "UPDATE sessions SET participants = participants ";
            $sql .= $sign;
            $sql .= " 1 WHERE id = $session_id";

			$query = $this->db->query($sql);
		}

        function Update_user_data($session_id, $participant_id, $new_name, $new_avatar){

            $avatar_change = (($new_avatar == '-1' && strlen($new_avatar) == 0) ? 0 : 1);

            $sql = "UPDATE participants SET name = '$new_name'";
            if($avatar_change) $sql .= ", avatar = '$new_avatar'";
            $sql .= " WHERE session_id = $session_id AND p_id = $participant_id";

            $query = $this->db->query($sql);

        }

}
