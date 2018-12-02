<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Assignment_model extends CI_Model{

		function __construct(){
	    	parent::__construct();
	    }

        function Validate_key($key)
		{
            $sql = "SELECT session_id FROM identificators WHERE user_id = '$key' OR gm_id = '$key'";
            $query = $this->db->query($sql);

            if(isset($query->row()->session_id) && $query->row()->session_id) return 1;
            else return 0;
        }

        function Get_session_id_by_key($key)
		{

            $sql = "SELECT session_id FROM identificators WHERE gm_id = '$key' OR user_id = '$key'";
            $query = $this->db->query($sql);

			$sessionID = 0;
			if(isset( $query->row()->session_id )) $sessionID = $query->row()->session_id;

            return $sessionID;

        }

        function Get_all_session_information($sessionId)
		{

            $sql = "SELECT name, participants, dices, quotes, quotes_all, goddice, goddice_all FROM sessions WHERE id = $sessionId";

             $query = $this->db->query($sql);
             return $query->row();

        }

        function getAllParticipantsInformation( $sessionId )
		{
            $sql = "SELECT name, avatar, rank, id, userId FROM participants WHERE session_id = $sessionId";

            $query = $this->db->query($sql);
            return $query->result();
        }

		function Get_admin_key($sessionId)
		{

			$sql = "SELECT gm_id FROM identificators WHERE session_id = $sessionId";

			$query = $this->db->query($sql);
			return $query->row()->gm_id;
		}

    }
