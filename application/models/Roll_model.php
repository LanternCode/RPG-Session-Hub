<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Roll_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Update_Roll_History($data=[]){
            $data = (object) $data;
            $who = $_SESSION['who'];
			$session_id = $_SESSION['session_id'];
            date_default_timezone_set('Poland');
			$time = date('Y/m/d H:i:s');

            $sql = "INSERT INTO rolls(session_id, value, who, what, rolldate, doubleroll)VALUES($session_id,'$data->roll','$who','$data->comment','$time',$data->double)";
            $query = $this->db->query($sql);

            return 1;
        }

		function Get_Roll_History()
		{

			$id = $_SESSION['session_id'];

			$sql = "SELECT value, who, what, doubleroll
			FROM rolls
			WHERE rolldate >= date_sub(NOW(), interval 1 hour)
			AND session_id = '$id'
			ORDER BY rollid DESC";

			$query = $this->db->query($sql);

			return $query->result();
		}

		function Increment_rollcount($double)
		{
			$increment_by = ($double) ? 2 : 1;
			$sql = "UPDATE misc SET rollcount = rollcount + $increment_by";
		}

		function Roll_the_dice($dice){

			if($dice == 'K4') return rand(1, 4);
			else if($dice == 'K6') return rand(1, 6);
			else if ($dice == 'K8') return rand(1, 8);
			else if ($dice == 'K10') return rand(1, 10);
			else if ($dice == 'K12') return rand(1, 12);
			else if ($dice == 'K20') return rand(1, 20);
			else return rand(1, 100);


		}

}
