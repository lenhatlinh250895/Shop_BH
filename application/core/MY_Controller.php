<?php 
/**
 * 
 */
class MY_Controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$controller = $this->uri->segment(1);
		switch ($controller) {
			case 'admin':
				{
					$this->load->helper('admin');
					$this->checkLogin();
					break;
				}
			default:
				{
					break;
				}
		}
		
	}

	private function checkLogin()
	{
		$controller = $this->uri->rsegment(1);
		$controller = strtolower($controller);
		//textData($controller);

		$login  = $this->session->userdata('admin');
		if(!$login && $controller != 'login')
		{
			redirect(admin_url('Login'));
		} 
		if($login && $controller == 'login')
		{
			redirect(admin_url('Home'));
		}
	}
}
?>