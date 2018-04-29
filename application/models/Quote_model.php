<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Quote_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Get_daily_quote($session_id, $quote_count){

			$quote_num = rand(0, $quote_count-1);

            $sql = "SELECT quote FROM quotes WHERE session_id = $session_id ORDER BY id LIMIT 1 OFFSET $quote_num";
            $query = $this->db->query($sql);

            return $query->row()->quote;
        }

		function Get_session_quote_number($session_id){

			$sql = "SELECT count(*) AS num FROM quotes WHERE session_id = $session_id";
			$query = $this->db->query($sql);
			$to_return = (isset($query->row()->num)) ? $query->row()->num : 0;

			return $to_return;

		}

}
