<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function Update_Rolls(){

 		$that = &get_instance();
        $that->load->model('Roll_model');
        $rolls = $that->Roll_model->Get_Roll_History();
		return $rolls;

	}


?>
