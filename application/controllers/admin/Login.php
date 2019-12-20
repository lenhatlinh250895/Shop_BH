<?php 
/**
 * 
 */
class Login extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		if($this->input->post())
		{
			$this->form_validation->set_rules('login','Login','callback_checkLogin');
			if($this->form_validation->run())
			{
				$this->session->set_userdata('admin',true);
				redirect(admin_url('Home'));
			}
		}
		$this->load->view('admin/login/index');
	}

	function checkLogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password = md5($password);

		$this->load->model('admin/Admin_M');
		$where = array(
			'username' => $username,
			'password' => $password
		);
		if($this->Admin_M->checkExists($where))
		{
			return true;
		}
		$this->form_validation->set_message(__FUNCTION__,'Login failed!');
		return false;
	}

}
?>