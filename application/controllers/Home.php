<?php defined('BASEPATH') OR exit('No direct script access allowed');
if( !isset( $_SESSION ) ) session_start();

class Home extends CI_Controller
{

	public function __construct()
	{
    	parent::__construct();
    }

	public function index()
	{
		if( isset( $_SESSION['connected'] ) )
		{
			//User already logged in
			redirect( base_url( 'sesyjka' ) );
		}
		else
		{
			$data = array(
				'title' => 'Session Hub',
				'body' => 'Homepage'
			);
			$this->load->view( 'templates/main', $data );
		}
	}

	public function newsession()
	{
		if( isset( $_SESSION['connected'] ) )
		{
			//User already logged in
			redirect( base_url( 'sesyjka' ) );
		}
		else
		{
			$data = array(
				'title' => 'Session Hub',
				'body' => 'createSession/CreatePage1'
			);
			$this->load->view( 'templates/main', $data );
		}
	}

}

?>
