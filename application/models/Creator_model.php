<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Creator_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Create_session($data = [])
		{
            $data = (object) $data;

            $sql = "INSERT INTO sessions (name,participants,type)VALUES('$data->session_name',$data->participants,$data->type)";
            $query = $this->db->query($sql);

            return 1;
        }

		function GetSessionIdBySessionName($name)
		{
			$sql = "SELECT id FROM sessions WHERE name = '$name'";
			$query = $this->db->query($sql);
			return $query->row()->id;
		}

		function Assign_dices($sessionId,$dices)
		{

			$sql = "UPDATE sessions SET dices = '$dices' WHERE id = $sessionId";
			$query = $this->db->query($sql);

		}

		function Add_user_id($user_id, $gm_id)
		{

			$sql = "UPDATE identificators SET user_id = '$user_id' WHERE gm_id = '$gm_id'";
			$query = $this->db->query($sql);

		}

}
