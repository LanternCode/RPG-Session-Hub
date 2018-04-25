<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Creator_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Create_session($data = []){
            $data = (object) $data;

            $sql = "INSERT INTO sessions (name,participants,type)VALUES('$data->session_name',$data->participants,$data->type)";
            $query = $this->db->query($sql);

            return 1;
        }

		function Add_participants($id, $name, $avatar, $rank){

			$sql = "INSERT INTO participants (session_id, name, avatar, rank)VALUES($id, '$name', '$avatar', '$rank')";
			$query = $this->db->query($sql);

		}

		function GetSessionIdBySessionName($name){
			$sql = "SELECT id FROM sessions WHERE name = '$name'";
			$query = $this->db->query($sql);
			return $query->row()->id;
		}

		function Assign_dices($session_id,$dices){

			$sql = "UPDATE sessions SET dices = '$dices' WHERE id = $session_id";
			$query = $this->db->query($sql);

		}

		function Is_session_first_name_part_unique($namepart){
			$sql = "SELECT namepart FROM identificators WHERE namepart = '$namepart'";
			$query = $this->db->query($sql);

			if(!isset($query->row()->namepart)) return 1;
			else return 0;
		}

		function Assert_unique_session_first_name_part($namepart){
			return $namepart.'1';
		}

		function Insert_into_identificators($session_id, $namepart, $gm_id){

			$sql = "INSERT INTO identificators (session_id, namepart, gm_id)VALUES($session_id, '$namepart', '$gm_id')";
			$query = $this->db->query($sql);

		}

		function Add_user_id($user_id, $gm_id){

			$sql = "UPDATE identificators SET user_id = '$user_id' WHERE gm_id = '$gm_id'";
			$query = $this->db->query($sql);

		}

		function Increase_participant_count($session_id){
			$sql = "UPDATE sessions SET participants = participants + 1 WHERE id = $session_id";
			$query = $this->db->query($sql);
		}

}
