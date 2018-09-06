<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

    function Validate_key( $adminName, $password )
	{

        $sql = "SELECT password FROM staff WHERE name = '$adminName'";
        $query = $this->db->query($sql);

        if( isset( $query->row()->password ) && strlen( $query->row()->password ) >= 8)
		{
            return ($password == $query->row()->password) ? 1 : 0;
        }
		else return 0;

    }

	function Get_admin_data($adminName){

		$sql = "SELECT * FROM staff WHERE name = '$adminName'";
		$query = $this->db->query($sql);
		return ((object) $query->row());

	}

	function Load_tickets(){

		$sql = "SELECT * FROM tickets WHERE status = 0";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}

}
