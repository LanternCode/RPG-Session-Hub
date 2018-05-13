<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Admin_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Validate_key($adminid, $password){

            $correct = 0;
            $sql = "SELECT password FROM staff WHERE admin_id = '$adminid'";
            $query = $this->db->query($sql);

            if(isset($query->row()->password) && strlen($query->row()->password) >= 8){
                return ($password == $query->row()->password) ? 1 : 0;
            }else{
                return 0;
            }

        }

		function Get_admin_data($admin_id){

			$sql = "SELECT * FROM staff WHERE admin_id = $admin_id";
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
