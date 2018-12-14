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

	function GetSessionIdBySessionName($name)
	{
		$sql = "SELECT id FROM sessions WHERE name = '$name'";
		$query = $this->db->query($sql);
		return $query->row()->id;
	}

	function Assign_dices($sessionId,$dices)
	{

		$sql = "UPDATE sessions SET dices = '$dices' WHERE id = $sessionId";
		$this->db->simple_query( $sql );

	}

}
