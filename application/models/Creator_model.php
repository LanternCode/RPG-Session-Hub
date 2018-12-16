<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creator_model extends CI_Model
{
	function __construct()
	{
	    parent::__construct();
	}

    function createSession( $data = [] )
	{
        $data = (object) $data;

        $sql = "INSERT INTO sessions (name,participants)VALUES('$data->session_name', $data->participants)";
        $this->db->simple_query( $sql );
    }

	function GetSessionIdBySessionName( $sessionName )
	{
		$sql = "SELECT id FROM sessions WHERE name = '$sessionName'";
		$query = $this->db->query($sql);

		return isset($query->row()->id) ? $query->row()->id : 0;
	}

	function Assign_dices( $sessionId, $dices )
	{

		$sql = "UPDATE sessions SET dices = '$dices' WHERE id = $sessionId";
		$this->db->simple_query( $sql );

	}

}
