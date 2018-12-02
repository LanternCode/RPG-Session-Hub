<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function Get_daily_quote(){

 		$that = &get_instance();
        $that->load->model('Quote_model');
		$quote_count = $that->Quote_model->Get_session_quote_number( $_SESSION['connectedSessionId'] );
		if($quote_count > 0) $quote = $that->Quote_model->Get_daily_quote( $_SESSION['connectedSessionId'], $quote_count );
		else $quote = 'There are no quotes added! Add some and make them appear here!';

		return $quote;
	}

?>
