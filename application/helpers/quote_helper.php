<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function Get_daily_quote(){

 		$that = &get_instance();
        $that->load->model('Quote_model');
        $quote = $that->Quote_model->Get_daily_quote();
		return $quote;
	}

?>
