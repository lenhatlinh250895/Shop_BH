<?php 
/**
 * 
 */
class Home extends MY_Controller
{
	public function index()
	{
		$data['temp'] = 'admin/home/index';
		$data['head'] = 'admin/head';
		$data['script'] = 'admin/script';
		$this->load->view('admin/main',$data);
	}
}
?>	






