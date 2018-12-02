<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Quote_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Get_daily_quote($sessionId, $quote_count)
		{

			$quote_num = rand(0, $quote_count-1);

            $sql = "SELECT quote FROM quotes WHERE session_id = $sessionId ORDER BY id LIMIT 1 OFFSET $quote_num";
            $query = $this->db->query($sql);

            return $query->row()->quote;
        }

		function Get_session_quote_number($sessionId)
		{

			$sql = "SELECT count(*) AS num FROM quotes WHERE session_id = $sessionId";
			$query = $this->db->query($sql);
			$to_return = (isset($query->row()->num)) ? $query->row()->num : 0;

			return $to_return;

		}

}
