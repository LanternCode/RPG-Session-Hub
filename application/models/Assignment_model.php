<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Assignment_model extends CI_Model{

		function __construct(){
	    	parent::__construct();
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

    }
