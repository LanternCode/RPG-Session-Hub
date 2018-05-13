<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Admin_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Validate_key($key, $password){

            $correct = 0;
            $sql = "SELECT password FROM staff WHERE name = '$key'";
            $query = $this->db->query($sql);

            if(isset($query->row()->password) && strlen($query->row()->password) >= 8){
                return ($password == $query->row()->password) ? 1 : 0;
            }else{
                return 0;
            }

        }



}
