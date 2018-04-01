<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Assignment_model extends CI_Model{

		 function __construct(){
	     parent::__construct();
	    }


        function Validate_key($key){
            $sql = "SELECT session_id FROM identificators WHERE user_id = '$key' OR gm_id = '$key'";
            $query = $this->db->query($sql);

            if($query) return 1;
            else return 0;
        }

        function Get_session_id_by_key($key){

            $sql = "SELECT session_id FROM identificators WHERE gm_id = '$key' OR user_id = '$key'";
            $query = $this->db->query($sql);

            return $query->row()->session_id;

        }

        function Get_all_session_information($session_id){

            $sql = "SELECT name, participants, dices, quotes FROM sessions WHERE id = $session_id";

             $query = $this->db->query($sql);
             return $query->row();

        }

        function Get_all_participant_information($session_id){

            $sql = "SELECT name, avatar, rank FROM participants WHERE session_id = $session_id";

            $query = $this->db->query($sql);
            return $query->result();

        }

    }
