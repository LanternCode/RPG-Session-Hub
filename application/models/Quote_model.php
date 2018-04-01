<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Quote_model extends CI_Model{
		 function __construct(){
	     parent::__construct();
	    }

        function Get_daily_quote(){

            $quote_num = rand(1, 60);

            $sql = "SELECT quote FROM quotes WHERE id = $quote_num";
            $query = $this->db->query($sql);

            return $query->row()->quote;
        }

}
